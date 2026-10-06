<?php

namespace App\Http\Controllers;

use App\Models\Userdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiplomaDownloadController extends Controller
{
    public function download(Request $request, Userdata $userdata, string $filename)
    {
        $user = $request->user();
        abort_unless($user, 403);

        $isOwner = (int) $userdata->utilisateur_id === (int) $user->id;
        abort_unless($isOwner || $user->hasRole('admin'), 403);
        abort_unless(preg_match('/\A[a-zA-Z0-9][a-zA-Z0-9._-]{0,179}\z/', $filename) === 1, 404);

        $path = 'diplomes/' . $userdata->utilisateur_id . '/' . $filename;
        $disk = Storage::disk('local');
        abort_unless($disk->exists($path), 404);

        return $disk->download($path, $filename, [
            'Cache-Control' => 'private, no-store, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
