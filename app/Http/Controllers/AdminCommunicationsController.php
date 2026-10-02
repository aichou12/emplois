<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailCampaignChunk;
use App\Models\Academic;
use App\Models\AdminEmailCampaign;
use App\Models\AdminEmailCampaignRecipient;
use App\Models\Emploi;
use App\Models\Region;
use App\Models\Secteur;
use App\Services\CampaignAudience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCommunicationsController extends Controller
{
    public function index(CampaignAudience $audience)
    {
        return view('admin.communications.index', $this->pageData($audience));
    }

    public function edit(AdminEmailCampaign $campaign, CampaignAudience $audience)
    {
        abort_unless($campaign->status === 'draft', 404);

        return view('admin.communications.index', $this->pageData($audience, $campaign));
    }

    private function pageData(CampaignAudience $audience, ?AdminEmailCampaign $editingCampaign = null): array
    {
        return [
            'campaigns' => AdminEmailCampaign::latest()->paginate(8)->withQueryString(),
            'regions' => Region::orderBy('libelle')->get(['id', 'libelle']),
            'academics' => Academic::orderBy('libelle')->get(['id', 'libelle']),
            'sectors' => Secteur::orderBy('libelle')->get(['id', 'libelle']),
            'employments' => Emploi::orderBy('libelle')->get(['id', 'libelle']),
            'audienceCount' => $audience->query($editingCampaign?->filters ?? ['status' => 'active'])->count(),
            'editingCampaign' => $editingCampaign,
        ];
    }

    public function audienceCount(Request $request, CampaignAudience $audience)
    {
        $filters = $this->validateFilters($request);

        return response()->json(['count' => $audience->query($filters)->count()]);
    }

    public function store(Request $request, CampaignAudience $audience)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:180', 'not_regex:/[\r\n]/'],
            'body' => ['required', 'string', 'max:10000'],
        ]);
        $filters = array_filter($this->validateFilters($request), fn ($value) => filled($value));

        $campaign = AdminEmailCampaign::create([
            'name' => trim($validated['name']),
            'subject' => trim($validated['subject']),
            'body' => trim($validated['body']),
            'filters' => $filters,
            'channel' => 'email',
            'status' => 'draft',
            'recipient_count' => $audience->query($filters)->count(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.communications')->with('success', 'Le brouillon « ' . $campaign->name . ' » a été enregistré.');
    }

    public function update(Request $request, AdminEmailCampaign $campaign, CampaignAudience $audience)
    {
        abort_unless($campaign->status === 'draft', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:180', 'not_regex:/[\r\n]/'],
            'body' => ['required', 'string', 'max:10000'],
        ]);
        $filters = array_filter($this->validateFilters($request), fn ($value) => filled($value));

        $campaign->update([
            'name' => trim($validated['name']),
            'subject' => trim($validated['subject']),
            'body' => trim($validated['body']),
            'filters' => $filters,
            'recipient_count' => $audience->query($filters)->count(),
        ]);

        return redirect()->route('admin.communications')->with('success', 'Le brouillon « ' . $campaign->name . ' » a été mis à jour.');
    }

    public function send(AdminEmailCampaign $campaign, CampaignAudience $audience)
    {
        abort_unless($campaign->status === 'draft', 404);
        $filters = $campaign->filters ?? [];
        $recipientCount = $audience->query($filters)->count();
        if ($recipientCount === 0) {
            return back()->withErrors(['campaign' => 'Aucun candidat avec une adresse e-mail ne correspond à ces critères.']);
        }

        if ($recipientCount !== (int) $campaign->recipient_count) {
            $campaign->update(['recipient_count' => $recipientCount]);
            return back()->withErrors(['campaign' => 'La liste des destinataires a changé depuis l’enregistrement du brouillon. Le nombre a été actualisé ; vérifie-le avant de confirmer l’envoi.']);
        }

        DB::transaction(function () use ($campaign, $filters, $audience, $recipientCount) {
            $lockedCampaign = AdminEmailCampaign::whereKey($campaign->id)->lockForUpdate()->firstOrFail();
            abort_unless($lockedCampaign->status === 'draft', 409);

            $lockedCampaign->recipients()->delete();
            $audience->query($filters)
                ->select(['utilisateur.id', 'utilisateur.email'])
                ->orderBy('utilisateur.id')
                ->chunkById(300, function ($users) use ($lockedCampaign) {
                    $now = now();
                    $rows = $users->map(fn ($user) => [
                        'campaign_id' => $lockedCampaign->id,
                        'utilisateur_id' => $user->id,
                        'email' => $user->email,
                        'status' => 'pending',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ])->all();
                    AdminEmailCampaignRecipient::insert($rows);
                }, 'utilisateur.id');

            $lockedCampaign->update([
                'status' => 'queued',
                'recipient_count' => $recipientCount,
                'dispatched_at' => now(),
            ]);
        });

        $campaign->recipients()->orderBy('id')->chunk(20, function ($recipients) use ($campaign) {
            SendEmailCampaignChunk::dispatch($campaign->id, $recipients->pluck('id')->all());
        });

        return redirect()->route('admin.communications')->with('success', 'L’envoi de « ' . $campaign->name . ' » a été placé dans la file d’attente.');
    }

    private function validateFilters(Request $request): array
    {
        $validated = $request->validate([
            'filters.status' => ['nullable', 'in:complete,incomplete,active,inactive,recruited,not_recruited'],
            'filters.region' => ['nullable', 'integer', 'exists:region,id'],
            'filters.academic' => ['nullable', 'string', function (string $attribute, mixed $value, \Closure $fail) {
                if (!in_array($value, ['with', 'without'], true) && (!ctype_digit((string) $value) || !Academic::whereKey((int) $value)->exists())) {
                    $fail('Choisis un niveau de diplôme valide.');
                }
            }],
            'filters.gender' => ['nullable', 'in:Masculin,Feminin'],
            'filters.sector' => ['nullable', 'integer', 'exists:secteur,id'],
            'filters.employment' => ['nullable', 'integer', 'exists:emploi,id'],
            'filters.experience' => ['nullable', 'in:none,1-2,3-5,6-plus'],
            'filters.age' => ['nullable', 'in:18-30,31-45,46-plus'],
            'filters.registered_year' => ['nullable', 'integer', 'min:2000', 'max:' . now()->year],
        ]);

        return $validated['filters'] ?? [];
    }
}
