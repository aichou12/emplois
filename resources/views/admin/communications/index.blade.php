<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Communications — Administration PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-sidebar-sage-v4">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-communications.css') }}?v=communications-v1">
</head>
<body>
    @include('partials.site-header')
    <div class="wrapper pgde-admin-wrapper">
        @include('admin.partials.sidebar')
        <main class="main-panel pgde-admin-main">
            @include('admin.partials.page-header')
            <div class="container"><div class="page-inner">
                <div class="pgde-communications-page">
                    @if(session('success'))<div class="pgde-comms-alert is-success" role="status"><i class="fas fa-check-circle" aria-hidden="true"></i>{{ session('success') }}</div>@endif
                    @if($errors->any())<div class="pgde-comms-alert is-error" role="alert"><i class="fas fa-exclamation-circle" aria-hidden="true"></i><div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div></div>@endif

                    <section class="pgde-comms-hero">
                        <div class="pgde-comms-hero-copy">
                            <span class="pgde-comms-eyebrow">CENTRE DE MESSAGERIE</span>
                            <h2>Une information, les bons candidats.</h2>
                            <p>Créez une communication ciblée et retrouvez vos brouillons et campagnes au même endroit.</p>
                        </div>
                        <div class="pgde-comms-hero-art" aria-hidden="true"><span><i class="fas fa-paper-plane"></i></span><i class="fas fa-sparkles"></i></div>
                    </section>

                    <form action="{{ $editingCampaign ? route('admin.communications.update', $editingCampaign) : route('admin.communications.store') }}" method="POST" id="pgdeCampaignForm" class="pgde-comms-layout" data-audience-url="{{ route('admin.communications.audience') }}">
                        @csrf
                        @if($editingCampaign) @method('PUT') @endif
                        <div class="pgde-comms-editor">
                            <section class="pgde-comms-panel pgde-comms-channel-panel">
                                <div class="pgde-comms-section-heading"><span class="pgde-comms-step">01</span><div><h3>Choisir un canal</h3><p>Le canal e-mail est prêt. Le SMS sera ajouté plus tard.</p></div></div>
                                <div class="pgde-comms-channel-choice">
                                    <label class="pgde-comms-channel is-selected">
                                        <input type="radio" name="channel_display" value="email" checked>
                                        <span class="pgde-comms-channel-icon"><i class="fas fa-envelope"></i></span>
                                        <span class="pgde-comms-channel-copy"><strong>E-mail</strong><small>Disponible maintenant</small></span>
                                        <i class="fas fa-check-circle pgde-comms-channel-check" aria-hidden="true"></i>
                                    </label>
                                    <div class="pgde-comms-channel is-disabled" aria-disabled="true">
                                        <span class="pgde-comms-channel-icon"><i class="fas fa-comment-dots"></i></span>
                                        <span class="pgde-comms-channel-copy"><strong>SMS</strong><small>Connecteur à venir</small></span>
                                        <span class="pgde-comms-coming-soon">Bientôt</span>
                                    </div>
                                </div>
                            </section>

                            <section class="pgde-comms-panel">
                                <div class="pgde-comms-section-heading"><span class="pgde-comms-step">02</span><div><h3>{{ $editingCampaign ? 'Modifier le brouillon' : 'Nommer et rédiger' }}</h3><p>Le nom est visible uniquement dans l’administration.</p></div></div>
                                <label class="pgde-comms-field"><span>Nom de la communication</span><input type="text" name="name" maxlength="120" value="{{ old('name', $editingCampaign?->name) }}" placeholder="Ex. Rappel des dossiers à compléter" required data-campaign-name></label>
                                <label class="pgde-comms-field"><span>Objet de l’e-mail</span><input type="text" name="subject" maxlength="180" value="{{ old('subject', $editingCampaign?->subject) }}" placeholder="Ex. Votre dossier candidat vous attend" required data-campaign-subject></label>
                                <label class="pgde-comms-field"><span>Message</span><textarea name="body" rows="7" maxlength="10000" placeholder="Rédigez votre message ici…" required data-campaign-body>{{ old('body', $editingCampaign?->body) }}</textarea><small>Le contenu est envoyé en texte simple avec le modèle graphique PGDE. Retours à la ligne conservés.</small></label>
                            </section>

                            <section class="pgde-comms-panel">
                                <div class="pgde-comms-section-heading"><span class="pgde-comms-step">03</span><div><h3>Définir les destinataires</h3><p>Combinez les critères. Seuls les comptes avec une adresse e-mail seront comptés.</p></div></div>
                                <div class="pgde-comms-filter-grid">
                                    <label class="pgde-comms-field"><span>État du compte ou dossier</span><select name="filters[status]" data-audience-filter><option value="">Tous les candidats</option><option value="active" @selected(old('filters.status', data_get($editingCampaign, 'filters.status', 'active')) === 'active')>Compte activé</option><option value="inactive" @selected(old('filters.status', data_get($editingCampaign, 'filters.status')) === 'inactive')>Compte non activé</option><option value="complete" @selected(old('filters.status', data_get($editingCampaign, 'filters.status')) === 'complete')>Dossier complet</option><option value="incomplete" @selected(old('filters.status', data_get($editingCampaign, 'filters.status')) === 'incomplete')>Dossier incomplet</option><option value="recruited" @selected(old('filters.status', data_get($editingCampaign, 'filters.status')) === 'recruited')>Recruté</option><option value="not_recruited" @selected(old('filters.status', data_get($editingCampaign, 'filters.status')) === 'not_recruited')>Non recruté</option></select></label>
                                    <label class="pgde-comms-field"><span>Région de résidence</span><select name="filters[region]" data-audience-filter><option value="">Toutes les régions</option>@foreach($regions as $region)<option value="{{ $region->id }}" @selected((string) old('filters.region', data_get($editingCampaign, 'filters.region')) === (string) $region->id)>{{ $region->libelle }}</option>@endforeach</select></label>
                                    <label class="pgde-comms-field"><span>Niveau de diplôme</span><select name="filters[academic]" data-audience-filter><option value="">Tous les niveaux</option><option value="with" @selected(old('filters.academic', data_get($editingCampaign, 'filters.academic')) === 'with')>Avec diplôme</option><option value="without" @selected(old('filters.academic', data_get($editingCampaign, 'filters.academic')) === 'without')>Sans diplôme</option>@foreach($academics->where('id', '!=', 20) as $academic)<option value="{{ $academic->id }}" @selected((string) old('filters.academic', data_get($editingCampaign, 'filters.academic')) === (string) $academic->id)>{{ $academic->libelle }}</option>@endforeach</select></label>
                                    <label class="pgde-comms-field"><span>Secteur souhaité</span><select name="filters[sector]" data-audience-filter><option value="">Tous les secteurs</option>@foreach($sectors as $sector)<option value="{{ $sector->id }}" @selected((string) old('filters.sector', data_get($editingCampaign, 'filters.sector')) === (string) $sector->id)>{{ $sector->libelle }}</option>@endforeach</select></label>
                                    <label class="pgde-comms-field"><span>Métier souhaité</span><select name="filters[employment]" data-audience-filter><option value="">Tous les métiers</option>@foreach($employments as $employment)<option value="{{ $employment->id }}" @selected((string) old('filters.employment', data_get($editingCampaign, 'filters.employment')) === (string) $employment->id)>{{ $employment->libelle }}</option>@endforeach</select></label>
                                    <label class="pgde-comms-field"><span>Expérience professionnelle</span><select name="filters[experience]" data-audience-filter><option value="">Toutes les expériences</option><option value="none" @selected(old('filters.experience', data_get($editingCampaign, 'filters.experience')) === 'none')>Sans expérience</option><option value="1-2" @selected(old('filters.experience', data_get($editingCampaign, 'filters.experience')) === '1-2')>1 à 2 ans</option><option value="3-5" @selected(old('filters.experience', data_get($editingCampaign, 'filters.experience')) === '3-5')>3 à 5 ans</option><option value="6-plus" @selected(old('filters.experience', data_get($editingCampaign, 'filters.experience')) === '6-plus')>6 ans et plus</option></select></label>
                                    <label class="pgde-comms-field"><span>Tranche d’âge</span><select name="filters[age]" data-audience-filter><option value="">Tous les âges</option><option value="18-30" @selected(old('filters.age', data_get($editingCampaign, 'filters.age')) === '18-30')>18 à 30 ans</option><option value="31-45" @selected(old('filters.age', data_get($editingCampaign, 'filters.age')) === '31-45')>31 à 45 ans</option><option value="46-plus" @selected(old('filters.age', data_get($editingCampaign, 'filters.age')) === '46-plus')>46 ans et plus</option></select></label>
                                    <label class="pgde-comms-field"><span>Genre</span><select name="filters[gender]" data-audience-filter><option value="">Tous les genres</option><option value="Masculin" @selected(old('filters.gender', data_get($editingCampaign, 'filters.gender')) === 'Masculin')>Hommes</option><option value="Feminin" @selected(old('filters.gender', data_get($editingCampaign, 'filters.gender')) === 'Feminin')>Femmes</option></select></label>
                                    <label class="pgde-comms-field"><span>Année d’inscription</span><input type="number" name="filters[registered_year]" min="2000" max="{{ now()->year }}" value="{{ old('filters.registered_year', data_get($editingCampaign, 'filters.registered_year')) }}" placeholder="Toutes les années" data-audience-filter></label>
                                </div>
                            </section>
                        </div>

                        <aside class="pgde-comms-aside">
                            <section class="pgde-comms-audience-card" aria-live="polite">
                                <span class="pgde-comms-audience-icon"><i class="fas fa-users" aria-hidden="true"></i></span>
                                <span class="pgde-comms-audience-label">Destinataires estimés</span>
                                <strong id="pgdeAudienceCount" data-initial-count="{{ $audienceCount }}">{{ number_format($audienceCount, 0, ',', ' ') }}</strong>
                                <small>Le total est recalculé selon les critères choisis.</small>
                                <span class="pgde-comms-audience-live" id="pgdeAudienceState"><i class="fas fa-circle" aria-hidden="true"></i> Calcul à jour</span>
                            </section>

                            <section class="pgde-comms-preview-card" aria-label="Aperçu du message">
                                <div class="pgde-comms-preview-top"><span><i class="far fa-eye" aria-hidden="true"></i> Aperçu</span><span class="pgde-comms-preview-live"><i class="fas fa-circle"></i> Direct</span></div>
                                <div class="pgde-comms-preview-mail">
                                    <div class="pgde-comms-preview-brand"><img src="{{ asset('images/logoPGDE-email.png') }}" alt="Logo PGDE"><span>PLATEFORME PGDE</span></div>
                                    <div class="pgde-comms-preview-content"><small>INFORMATION AUX CANDIDATS</small><h4 data-preview-subject>Objet de votre e-mail</h4><p>Bonjour,</p><div data-preview-body>Votre message apparaîtra ici au fur et à mesure de votre rédaction.</div></div>
                                    <div class="pgde-comms-preview-footer">Ministère de la Fonction Publique<br>Plateforme PGDE</div>
                                </div>
                            </section>

                            <div class="pgde-comms-actions">
                                <button class="pgde-comms-save-button" type="submit"><i class="fas fa-save" aria-hidden="true"></i> {{ $editingCampaign ? 'Mettre à jour le brouillon' : 'Enregistrer en brouillon' }}</button>
                                <span><i class="fas fa-info-circle" aria-hidden="true"></i> L’envoi sera lancé depuis la liste après confirmation.</span>
                            </div>
                        </aside>
                    </form>

                    <section class="pgde-comms-campaigns" id="campaigns">
                        <div class="pgde-comms-list-heading"><div><span class="pgde-comms-eyebrow">VOTRE HISTORIQUE</span><h2>Campagnes et brouillons</h2></div><span class="pgde-comms-campaign-count">{{ $campaigns->total() }} communication(s)</span></div>
                        @forelse($campaigns as $campaign)
                            @php
                                $campaignStatus = [
                                    'draft' => ['Brouillon', 'draft'], 'queued' => ['En attente', 'queued'],
                                    'sending' => ['En cours', 'sending'], 'sent' => ['Envoyée', 'sent'],
                                    'completed_with_errors' => ['Terminée avec erreurs', 'errors'],
                                ][$campaign->status] ?? [ucfirst($campaign->status), 'draft'];
                            @endphp
                            <article class="pgde-comms-campaign-row">
                                <span class="pgde-comms-campaign-icon"><i class="fas {{ $campaign->status === 'draft' ? 'fa-file-alt' : 'fa-paper-plane' }}" aria-hidden="true"></i></span>
                                <div class="pgde-comms-campaign-main"><strong>{{ $campaign->name }}</strong><span>{{ $campaign->subject }}</span><small>{{ $campaign->created_at->format('d/m/Y à H:i') }} · {{ number_format($campaign->recipient_count, 0, ',', ' ') }} destinataire(s) visé(s)</small></div>
                                <span class="pgde-comms-status is-{{ $campaignStatus[1] }}">{{ $campaignStatus[0] }}</span>
                                @if($campaign->status === 'draft')
                                    <div class="pgde-comms-row-actions">
                                        <a class="pgde-comms-edit-button" href="{{ route('admin.communications.edit', $campaign) }}"><i class="fas fa-pen" aria-hidden="true"></i> Modifier</a>
                                        <form action="{{ route('admin.communications.send', $campaign) }}" method="POST" onsubmit="return confirm('Envoyer cette communication à {{ (int) $campaign->recipient_count }} destinataire(s) ?');">
                                            @csrf
                                            <button class="pgde-comms-send-button" type="submit" @disabled($campaign->recipient_count === 0)><i class="fas fa-paper-plane" aria-hidden="true"></i> Envoyer</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="pgde-comms-delivery-count">{{ number_format($campaign->sent_count, 0, ',', ' ') }} envoyé(s)@if($campaign->failed_count) · {{ $campaign->failed_count }} échec(s)@endif</span>
                                @endif
                            </article>
                        @empty
                            <div class="pgde-comms-empty"><span><i class="far fa-paper-plane" aria-hidden="true"></i></span><strong>Aucune communication pour le moment</strong><p>Votre premier brouillon apparaîtra ici.</p></div>
                        @endforelse
                        @if($campaigns->hasPages())<div class="pgde-comms-pagination">{{ $campaigns->links() }}</div>@endif
                    </section>
                </div>
            </div></div>
        </main>
    </div>
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pgde-admin.js') }}?v=settings-dropdown-v1"></script>
    <script src="{{ asset('assets/js/pgde-communications.js') }}?v=communications-v1"></script>
</body>
</html>
