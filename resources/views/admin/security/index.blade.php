<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sécurité & accès — Administration PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-sidebar-sage-v4">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-security.css') }}?v=security-v5">
</head>
<body>
    @include('partials.site-header')

    <div class="wrapper pgde-admin-wrapper">
        @include('admin.partials.sidebar')
        <main class="main-panel pgde-admin-main">
            @include('admin.partials.page-header')
            <div class="container"><div class="page-inner">
                <div class="pgde-security-page">
                    @if(session('success'))
                        <div class="security-alert is-success" role="status"><i class="fas fa-check-circle" aria-hidden="true"></i>{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="security-alert is-error" role="alert"><i class="fas fa-exclamation-circle" aria-hidden="true"></i><div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div></div>
                    @endif

                    <div class="security-intro">
                        <span class="security-intro-icon"><i class="fas fa-shield-alt" aria-hidden="true"></i></span>
                        <div><h2>Surveillance des accès</h2><p>Consultez les tentatives de connexion et gérez les suspensions. Les blocages d’adresse IP concernent l’espace usager ; l’administration reste accessible.</p></div>
                        <div class="security-counter"><strong>{{ $loginEvents->total() }}</strong><span>tentatives<br>journalisées</span></div>
                    </div>

                    <section class="security-panel" aria-labelledby="login-events-title">
                        <div class="security-panel-heading"><div><span class="security-kicker">ACTIVITÉ RÉCENTE</span><h2 id="login-events-title">Tentatives de connexion</h2><p>Connexions réussies, identifiants refusés, comptes non activés et tentatives limitées.</p></div><span class="security-panel-icon is-green"><i class="fas fa-history" aria-hidden="true"></i></span></div>
                        <form class="security-filters" method="GET" action="{{ route('admin.security') }}">
                            <label class="security-search-field"><i class="fas fa-search" aria-hidden="true"></i><input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Rechercher un nom, un e-mail ou une IP" aria-label="Rechercher dans les connexions"></label>
                            <label class="security-filter-field"><span>Canal</span><select name="channel"><option value="">Tous les canaux</option><option value="web" @selected(($filters['channel'] ?? '') === 'web')>Espace web</option><option value="admin" @selected(($filters['channel'] ?? '') === 'admin')>Administration</option><option value="mobile" @selected(($filters['channel'] ?? '') === 'mobile')>Application mobile</option><option value="historique" @selected(($filters['channel'] ?? '') === 'historique')>Historique existant</option></select></label>
                            <label class="security-filter-field"><span>Résultat</span><select name="result"><option value="">Tous les résultats</option><option value="success" @selected(($filters['result'] ?? '') === 'success')>Connexion réussie</option><option value="password_rejected" @selected(($filters['result'] ?? '') === 'password_rejected')>Mot de passe refusé</option><option value="account_not_found" @selected(($filters['result'] ?? '') === 'account_not_found')>Compte introuvable</option><option value="account_not_activated" @selected(($filters['result'] ?? '') === 'account_not_activated')>Compte non activé</option><option value="account_blocked" @selected(($filters['result'] ?? '') === 'account_blocked')>Compte suspendu</option><option value="admin_access_denied" @selected(($filters['result'] ?? '') === 'admin_access_denied')>Accès admin refusé</option><option value="rate_limited" @selected(($filters['result'] ?? '') === 'rate_limited')>Trop de tentatives</option></select></label>
                            <label class="security-filter-field"><span>Du</span><input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"></label>
                            <label class="security-filter-field"><span>Au</span><input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"></label>
                            <label class="security-filter-field"><span>Afficher</span><select name="per_page" aria-label="Nombre de tentatives par page"><option value="15" @selected($perPage === 15)>15 par page</option><option value="30" @selected($perPage === 30)>30 par page</option><option value="100" @selected($perPage === 100)>100 par page</option></select></label>
                            <button class="security-filter-submit" type="submit"><i class="fas fa-filter" aria-hidden="true"></i>Filtrer</button>
                            @if($hasFilters)<a class="security-filter-reset" href="{{ route('admin.security') }}">Effacer</a>@endif
                        </form>
                        <div class="security-result-count">{{ number_format($loginEvents->total(), 0, ',', ' ') }} résultat(s) @if($hasFilters) correspondant(s) aux filtres @else au total @endif</div>
                        <div class="security-table-wrap">
                            <table class="security-table">
                                <thead><tr><th>Compte</th><th>Résultat</th><th>Date et heure</th><th>Adresse IP</th><th>Canal</th></tr></thead>
                                <tbody>
                                    @forelse($loginEvents as $event)
                                        <tr>
                                            <td><strong>{{ trim(($event->utilisateur?->firstname ?? '') . ' ' . ($event->utilisateur?->lastname ?? '')) ?: ($event->utilisateur?->username ?? $event->identifier_hint ?? 'Identifiant masqué') }}</strong><small>{{ $event->utilisateur?->email ?? 'Compte non reconnu' }}</small></td>
                                            <td><span class="security-outcome is-{{ $event->result }}">{{ ['success' => 'Connexion réussie', 'password_rejected' => 'Mot de passe refusé', 'account_not_found' => 'Compte introuvable', 'account_not_activated' => 'Compte non activé', 'account_blocked' => 'Compte suspendu', 'admin_access_denied' => 'Accès admin refusé', 'rate_limited' => 'Trop de tentatives'][$event->result] ?? 'Résultat inconnu' }}</span></td>
                                            <td>{{ $event->created_at?->format('d/m/Y à H:i') ?? '—' }}</td>
                                            <td><code>{{ $event->ip_address ?: 'Non disponible' }}</code></td>
                                            <td><span class="security-channel is-{{ $event->channel }}">{{ ['admin' => 'Administration', 'mobile' => 'Application mobile', 'web' => 'Espace web', 'historique' => 'Historique existant'][$event->channel] ?? ucfirst($event->channel) }}</span><small title="{{ $event->user_agent ?? '' }}">{{ $event->user_agent ? \Illuminate\Support\Str::limit($event->user_agent, 56) : 'Appareil non renseigné' }}</small></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5"><div class="security-empty"><i class="fas fa-clock" aria-hidden="true"></i><strong>Aucune tentative journalisée</strong><span>Les prochaines tentatives de connexion apparaîtront ici.</span></div></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($loginEvents->hasPages())<div class="security-pagination">{{ $loginEvents->links('admin.partials.security-pagination') }}</div>@endif
                    </section>

                    <div class="security-management-grid">
                        <section class="security-panel" aria-labelledby="account-block-title">
                            <div class="security-panel-heading"><div><span class="security-kicker">SUSPENSION CIBLÉE</span><h2 id="account-block-title">Comptes suspendus</h2><p>La suspension empêche la connexion web et mobile et révoque les jetons mobiles.</p></div><span class="security-panel-icon is-yellow"><i class="fas fa-user-lock" aria-hidden="true"></i></span></div>
                            <button class="security-open-modal" type="button" data-open-security-modal="account-block-modal"><i class="fas fa-user-lock" aria-hidden="true"></i>Suspendre un compte</button>
                            @if($blockedAccounts->isNotEmpty())<label class="security-list-search"><i class="fas fa-search" aria-hidden="true"></i><input type="search" placeholder="Rechercher un compte suspendu" data-filter-list="blocked-account-list"></label>@endif
                            <div class="security-block-list" id="blocked-account-list">
                                @forelse($blockedAccounts as $block)
                                    <article class="security-block-row" data-security-entry>
                                        <div class="security-block-symbol"><i class="fas fa-user-slash" aria-hidden="true"></i></div>
                                        <div class="security-block-info"><strong>{{ $block->utilisateur?->firstname }} {{ $block->utilisateur?->lastname }}</strong><small>{{ $block->utilisateur?->email ?? 'Compte supprimé' }}</small><small>Suspendu le {{ $block->blocked_at?->format('d/m/Y à H:i') }}@if($block->reason) · {{ $block->reason }}@endif</small></div>
                                        <form method="POST" action="{{ route('admin.security.accounts.unblock', $block) }}" data-security-confirm="Réactiver ce compte ? Il pourra de nouveau se connecter.">
                                            @csrf @method('DELETE')<button class="security-release" type="submit" aria-label="Réactiver le compte"><i class="fas fa-unlock" aria-hidden="true"></i></button>
                                        </form>
                                    </article>
                                @empty
                                    <p class="security-list-empty">Aucun compte suspendu actuellement.</p>
                                @endforelse
                            </div>
                        </section>

                        <section class="security-panel" aria-labelledby="ip-block-title">
                            <div class="security-panel-heading"><div><span class="security-kicker">FILTRE RÉSEAU</span><h2 id="ip-block-title">Adresses IP bloquées</h2><p>Le blocage porte sur une adresse exacte et ne vise que l’espace usager.</p></div><span class="security-panel-icon is-blue"><i class="fas fa-network-wired" aria-hidden="true"></i></span></div>
                            <button class="security-open-modal is-ip" type="button" data-open-security-modal="ip-block-modal"><i class="fas fa-ban" aria-hidden="true"></i>Bloquer une adresse IP</button>
                            @if($blockedIps->isNotEmpty())<label class="security-list-search"><i class="fas fa-search" aria-hidden="true"></i><input type="search" placeholder="Rechercher une adresse IP" data-filter-list="blocked-ip-list"></label>@endif
                            <div class="security-block-list" id="blocked-ip-list">
                                @forelse($blockedIps as $block)
                                    <article class="security-block-row" data-security-entry>
                                        <div class="security-block-symbol is-blue"><i class="fas fa-network-wired" aria-hidden="true"></i></div>
                                        <div class="security-block-info"><strong class="security-ip-value">{{ $block->ip_address }}</strong><small>Bloquée le {{ $block->blocked_at?->format('d/m/Y à H:i') }}@if($block->reason) · {{ $block->reason }}@endif</small></div>
                                        <form method="POST" action="{{ route('admin.security.ips.unblock', $block) }}" data-security-confirm="Débloquer cette adresse IP ? Les visiteurs retrouveront l’accès à l’espace usager.">
                                            @csrf @method('DELETE')<button class="security-release" type="submit" aria-label="Débloquer l’adresse IP"><i class="fas fa-unlock" aria-hidden="true"></i></button>
                                        </form>
                                    </article>
                                @empty
                                    <p class="security-list-empty">Aucune adresse IP bloquée actuellement.</p>
                                @endforelse
                            </div>
                        </section>
                    </div>

                    <dialog class="security-modal" id="account-block-modal" aria-labelledby="account-modal-title">
                        <form method="POST" action="{{ route('admin.security.accounts.block') }}" class="security-modal-card">
                            @csrf
                            <button class="security-modal-x" type="button" data-close-security-modal aria-label="Fermer"><i class="fas fa-times" aria-hidden="true"></i></button>
                            <span class="security-modal-icon is-yellow"><i class="fas fa-user-lock" aria-hidden="true"></i></span>
                            <span class="security-kicker">SUSPENSION DE COMPTE</span>
                            <h2 id="account-modal-title">Suspendre un compte</h2>
                            <p>La personne ne pourra plus se connecter sur le web ou l’application mobile. Ses sessions mobiles seront également révoquées.</p>
                            <label for="security-account">E-mail ou nom d’utilisateur</label>
                            <input id="security-account" name="account" value="{{ old('account') }}" autocomplete="off" placeholder="exemple@domaine.sn" required>
                            <label for="security-account-reason">Motif <span>(facultatif)</span></label>
                            <input id="security-account-reason" name="reason" value="{{ old('reason') }}" maxlength="500" placeholder="Motif interne de la suspension">
                            <small class="security-modal-note"><i class="fas fa-info-circle" aria-hidden="true"></i> Tu ne peux pas suspendre ton propre compte ni le dernier administrateur actif.</small>
                            <div class="security-modal-actions"><button class="security-modal-cancel" type="button" data-close-security-modal>Annuler</button><button class="security-modal-confirm is-danger" type="submit"><i class="fas fa-lock" aria-hidden="true"></i>Confirmer la suspension</button></div>
                        </form>
                    </dialog>

                    <dialog class="security-modal" id="ip-block-modal" aria-labelledby="ip-modal-title">
                        <form method="POST" action="{{ route('admin.security.ips.block') }}" class="security-modal-card">
                            @csrf
                            <button class="security-modal-x" type="button" data-close-security-modal aria-label="Fermer"><i class="fas fa-times" aria-hidden="true"></i></button>
                            <span class="security-modal-icon is-blue"><i class="fas fa-network-wired" aria-hidden="true"></i></span>
                            <span class="security-kicker">BLOCAGE RÉSEAU</span>
                            <h2 id="ip-modal-title">Bloquer une adresse IP</h2>
                            <p>Cette adresse ne pourra plus accéder à l’espace usager. L’administration restera accessible.</p>
                            <label for="security-ip">Adresse IPv4 ou IPv6</label>
                            <input id="security-ip" name="ip_address" value="{{ old('ip_address') }}" inputmode="decimal" placeholder="203.0.113.10" required>
                            <label for="security-ip-reason">Motif <span>(facultatif)</span></label>
                            <input id="security-ip-reason" name="reason" value="{{ old('reason') }}" maxlength="500" placeholder="Motif interne du blocage">
                            <small class="security-modal-note is-warning"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> Une adresse partagée peut concerner plusieurs personnes. Le blocage pourra être levé depuis cette page.</small>
                            <div class="security-modal-actions"><button class="security-modal-cancel" type="button" data-close-security-modal>Annuler</button><button class="security-modal-confirm is-danger" type="submit"><i class="fas fa-ban" aria-hidden="true"></i>Confirmer le blocage</button></div>
                        </form>
                    </dialog>

                    <dialog class="security-modal security-confirm-modal" id="security-confirm-modal" aria-labelledby="security-confirm-title">
                        <div class="security-modal-card">
                            <span class="security-modal-icon is-green"><i class="fas fa-unlock" aria-hidden="true"></i></span>
                            <span class="security-kicker">CONFIRMATION</span>
                            <h2 id="security-confirm-title">Confirmer l’action</h2>
                            <p id="security-confirm-message">Confirmer la réactivation ?</p>
                            <div class="security-modal-actions"><button class="security-modal-cancel" type="button" data-close-security-modal>Annuler</button><button class="security-modal-confirm" type="button" id="security-confirm-submit"><i class="fas fa-check" aria-hidden="true"></i>Confirmer</button></div>
                        </div>
                    </dialog>
                </div>
            </div></div>
        </main>
    </div>
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pgde-admin.js') }}?v=settings-dropdown-v1"></script>
    <script>
        (() => {
            let pendingForm = null;
            document.querySelectorAll('[data-open-security-modal]').forEach((button) => {
                button.addEventListener('click', () => document.getElementById(button.dataset.openSecurityModal)?.showModal());
            });
            document.querySelectorAll('[data-close-security-modal]').forEach((button) => {
                button.addEventListener('click', () => button.closest('dialog')?.close());
            });
            document.querySelectorAll('.security-modal').forEach((dialog) => {
                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) dialog.close();
                });
            });
            document.querySelectorAll('[data-security-confirm]').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    pendingForm = form;
                    document.getElementById('security-confirm-message').textContent = form.dataset.securityConfirm;
                    document.getElementById('security-confirm-modal').showModal();
                });
            });
            document.getElementById('security-confirm-submit')?.addEventListener('click', () => pendingForm?.submit());

            document.querySelectorAll('[data-filter-list]').forEach((input) => {
                input.addEventListener('input', () => {
                    const list = document.getElementById(input.dataset.filterList);
                    const search = input.value.trim().toLocaleLowerCase();
                    list?.querySelectorAll('[data-security-entry]').forEach((entry) => {
                        entry.hidden = !entry.textContent.toLocaleLowerCase().includes(search);
                    });
                });
            });

            @if($errors->has('account'))
                document.getElementById('account-block-modal')?.showModal();
            @elseif($errors->has('ip_address'))
                document.getElementById('ip-block-modal')?.showModal();
            @endif
        })();
    </script>
</body>
</html>
