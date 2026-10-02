
<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <title>Candidats — Administration PGDE</title>
   <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
   <link rel="icon" href="/images/logogris.png" type="image/x-icon"/>


   <!-- Fonts and icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


   <!-- DataTables (CSS) -->
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />


   <!-- Bootstrap & Kaiadmin CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-sidebar-sage-v4" />
   <link rel="stylesheet" href="{{ asset('assets/css/pgde-demandeurs.css') }}?v=24" />


   <!-- Webfont -->
   <script src="assets/js/plugin/webfont/webfont.min.js"></script>
   <script>
     WebFont.load({
       google: { families: ["Public Sans:300,400,500,600,700", "Inter:400,500,600,700"] },
       custom: {
         families: [
           "Font Awesome 5 Solid",
           "Font Awesome 5 Regular",
           "Font Awesome 5 Brands",
           "simple-line-icons",
         ],
         urls: ["assets/css/fonts.min.css"],
       },
       active: function () {
         sessionStorage.fonts = true;
       },
     });
   </script>


   <!-- Styles personnalisés pour DataTables -->
   <style>
     /* Conteneur du champ de recherche DataTables */
     div.dataTables_filter {
         text-align: right;
         margin-bottom: 20px;
     }


     div.dataTables_filter input {
         width: 100%;
         max-width: 300px;
         padding: 12px 40px 12px 16px;
         border: 2px solid #ced4da;
         border-radius: 50px;
         background: #fff url("https://cdn-icons-png.flaticon.com/512/622/622669.png") no-repeat 96% center;
         background-size: 20px 20px;
         transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
         font-size: 15px;
     }


     div.dataTables_filter input:focus {
         border-color: #28a745;
         box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
         outline: none;
     }


     @media (max-width: 768px) {
         div.dataTables_filter {
             text-align: center;
         }
         div.dataTables_filter input {
             width: 90%;
             max-width: 100%;
         }
     }


     /* Pagination */
     .dataTables_paginate .paginate_button {
         padding: 6px 12px;
         border-radius: 10px;
         margin: 0 3px;
         border: none;
         background-color: #f1f1f1;
         color: #333 !important;
         transition: 0.2s ease-in-out;
     }
     .dataTables_paginate .paginate_button:hover {
         background-color: #28a745;
         color: white !important;
     }
     .dataTables_paginate .paginate_button.current {
         background-color: #28a745 !important;
         color: white !important;
         font-weight: bold;
     }


     .dataTables_info {
         font-size: 0.95rem;
         color: #555;
     }


     .dataTables_length select {
         border-radius: 10px;
         padding: 4px 8px;
     }


     /* Style supplémentaire pour le bouton "-" */
     .remove-filter-btn {
         margin-left: 8px;
     }
   </style>
</head>


<body>
    @include('partials.site-header')
<div class="wrapper pgde-admin-wrapper">
   @include('admin.partials.sidebar')


   <div class="main-panel pgde-admin-main">
       @include('admin.partials.page-header')

           <div class="container">
           <div class="page-inner pgde-demandeurs-page">
               @if(session('success'))
                   <div class="alert alert-success" role="status">{{ session('success') }}</div>
               @endif
               @if(session('error'))
                   <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
               @endif
               @php
                   $selectedStatus = request('statut');
                   if ($selectedStatus === null && request()->has('dossier')) {
                       $selectedStatus = request('dossier');
                   } elseif ($selectedStatus === null && request()->has('isActif')) {
                       $selectedStatus = request('isActif') ? 'actif' : 'inactif';
                   } elseif ($selectedStatus === null && request()->has('isRecruted')) {
                       $selectedStatus = request('isRecruted') ? 'recrute' : 'non_recrute';
                   }
               @endphp
               @php
                   $hasAdvancedFilters = request()->filled('emploi') || request()->filled('experience') || request()->filled('annee_inscription') || request()->filled('age');
               @endphp

               <form action="{{ route('liste.utilisateurs') }}" method="GET" class="pgde-candidate-tools">
                   <label class="pgde-candidate-search">
                       <i class="fas fa-search" aria-hidden="true"></i>
                       <input type="search" name="recherche" value="{{ request('recherche') }}" placeholder="Nom ou numéro d’inscription" aria-label="Rechercher un demandeur">
                   </label>
                   <select name="region" class="pgde-candidate-select" aria-label="Filtrer par région">
                       <option value="">Toutes les régions</option>
                       @foreach($regions as $region)
                           <option value="{{ $region->id }}" @selected((string) request('region') === (string) $region->id)>{{ $region->libelle }}</option>
                       @endforeach
                   </select>
                   <select name="diplome" class="pgde-candidate-select" aria-label="Filtrer par diplôme">
                       <option value="">Tous les diplômes</option>
                       <option value="avec" @selected(request('diplome') === 'avec')>Avec diplôme</option>
                       <option value="sans" @selected(request('diplome') === 'sans')>Sans diplôme</option>
                       @foreach($academics->where('id', '!=', 20) as $academic)
                           <option value="{{ $academic->id }}" @selected((string) request('diplome') === (string) $academic->id)>{{ $academic->libelle }}</option>
                       @endforeach
                   </select>
                   <select name="secteur" class="pgde-candidate-select" aria-label="Filtrer par secteur">
                       <option value="">Tous les secteurs</option>
                       @foreach($secteurs as $secteur)
                           <option value="{{ $secteur->id }}" @selected((string) request('secteur') === (string) $secteur->id)>{{ $secteur->libelle }}</option>
                       @endforeach
                   </select>
                   <select name="genre" class="pgde-candidate-select" aria-label="Filtrer par genre">
                       <option value="">Tous les genres</option>
                       <option value="Masculin" @selected(request('genre') === 'Masculin')>Hommes</option>
                       <option value="Feminin" @selected(request('genre') === 'Feminin')>Femmes</option>
                   </select>
                   <select name="statut" class="pgde-candidate-select" aria-label="Filtrer par statut">
                       <option value="">Tous les statuts</option>
                       <option value="complet" @selected($selectedStatus === 'complet')>Dossier complet</option>
                       <option value="incomplet" @selected($selectedStatus === 'incomplet')>Dossier incomplet</option>
                       <option value="actif" @selected($selectedStatus === 'actif')>Compte activé</option>
                       <option value="inactif" @selected($selectedStatus === 'inactif')>Compte non activé</option>
                       <option value="recrute" @selected($selectedStatus === 'recrute')>Recruté</option>
                       <option value="non_recrute" @selected($selectedStatus === 'non_recrute')>Non recruté</option>
                   </select>
                   <button class="pgde-candidate-advanced-toggle{{ $hasAdvancedFilters ? ' is-open' : '' }}" type="button" id="pgdeAdvancedToggle" aria-expanded="{{ $hasAdvancedFilters ? 'true' : 'false' }}" aria-controls="pgdeAdvancedFilters">
                       <i class="fas fa-sliders-h" aria-hidden="true"></i><span>Filtres avancés</span>
                       @if($hasAdvancedFilters)<span class="pgde-candidate-filter-count">{{ collect(['emploi', 'experience', 'annee_inscription', 'age'])->filter(fn ($key) => request()->filled($key))->count() }}</span>@endif
                       <i class="fas fa-chevron-down pgde-candidate-advanced-chevron" aria-hidden="true"></i>
                   </button>
                   <div class="pgde-candidate-advanced" id="pgdeAdvancedFilters" @if(!$hasAdvancedFilters) hidden @endif>
                       <div class="pgde-candidate-advanced-heading"><strong>Affiner la recherche</strong><span>Combine plusieurs critères, puis applique les filtres.</span></div>
                       <div class="pgde-candidate-advanced-fields">
                           <label class="pgde-candidate-advanced-field"><span>Métier souhaité</span>
                               <select name="emploi" class="pgde-candidate-select" aria-label="Filtrer par métier souhaité">
                                   <option value="">Tous les métiers</option>
                                   @foreach($emplois as $emploi)
                                       <option value="{{ $emploi->id }}" @selected((string) request('emploi') === (string) $emploi->id)>{{ $emploi->libelle }}</option>
                                   @endforeach
                               </select>
                           </label>
                           <label class="pgde-candidate-advanced-field"><span>Expérience professionnelle</span>
                               <select name="experience" class="pgde-candidate-select" aria-label="Filtrer par expérience professionnelle">
                                   <option value="">Toutes les expériences</option>
                                   <option value="sans" @selected(request('experience') === 'sans')>Sans expérience</option>
                                   <option value="1-2" @selected(request('experience') === '1-2')>1 à 2 ans</option>
                                   <option value="3-5" @selected(request('experience') === '3-5')>3 à 5 ans</option>
                                   <option value="6-plus" @selected(request('experience') === '6-plus')>6 ans et plus</option>
                               </select>
                           </label>
                           <label class="pgde-candidate-advanced-field"><span>Année d'inscription</span>
                               <input class="pgde-candidate-advanced-input" type="number" name="annee_inscription" min="2000" max="{{ now()->year }}" step="1" value="{{ request('annee_inscription') }}" placeholder="Ex. {{ now()->year }}" aria-label="Filtrer par année d'inscription">
                           </label>
                           <label class="pgde-candidate-advanced-field"><span>Tranche d’âge</span>
                               <select name="age" class="pgde-candidate-select" aria-label="Filtrer par tranche d’âge">
                                   <option value="">Tous les âges</option>
                                   <option value="18-30" @selected(request('age') === '18-30')>18 à 30 ans</option>
                                   <option value="31-45" @selected(request('age') === '31-45')>31 à 45 ans</option>
                                   <option value="46-plus" @selected(request('age') === '46-plus')>46 ans et plus</option>
                               </select>
                           </label>
                       </div>
                   </div>
                   <button class="pgde-candidate-apply" type="submit"><i class="fas fa-filter" aria-hidden="true"></i> Appliquer</button>
                   @if(request()->query())<a class="pgde-candidate-reset" href="{{ route('liste.utilisateurs') }}"><i class="fas fa-undo" aria-hidden="true"></i> Réinitialiser</a>@endif
                   <button class="pgde-candidate-export" type="button" id="exportExcel"><i class="fas fa-download" aria-hidden="true"></i> Exporter</button>
               </form>

               <section class="pgde-candidate-card" aria-label="Liste des demandeurs">
                   <div class="pgde-candidate-table-wrap">
                       <table id="mainUserTable">
                           <thead>
                               <tr>
                                   <th>Candidat</th>
                                   <th>Région</th>
                                   <th>Diplôme</th>
                                   <th>E-mail</th>
                                   <th>Dossier</th>
                                   <th><span class="visually-hidden">Actions</span></th>
                               </tr>
                           </thead>
                           <tbody>
                               @forelse($utilisateurs as $u)
                               <tr>
                                   <td>
                                       <div class="pgde-candidate-person">
                                           <span class="pgde-candidate-avatar">{{ mb_strtoupper(mb_substr($u->firstname ?: $u->username, 0, 1) . mb_substr($u->lastname ?? '', 0, 1)) }}</span>
                                           <span>{{ trim($u->firstname . ' ' . $u->lastname) ?: $u->username }}<small>N° d’inscription {{ $u->id }}</small></span>
                                       </div>
                                   </td>
                                   <td>{{ $u->userdata?->regionResidence?->libelle ?? $u->userdata?->pays?->name ?? '—' }}</td>
                                   <td>{{ $u->userdata?->academic?->libelle ?? '—' }}</td>
                                   <td>{{ $u->email ?: '—' }}</td>
                                   <td>
                                       <div class="pgde-candidate-status-stack">
                                       @if(!$u->enabled)
                                           <span class="pgde-candidate-status is-danger">Compte non activé</span>
                                       @elseif(!$u->userdata)
                                           <span class="pgde-candidate-status is-warning">Incomplet</span>
                                       @else
                                           <span class="pgde-candidate-status is-complete">Complet</span>
                                       @endif
                                       @if($u->recruted)
                                           <span class="pgde-candidate-status is-recruited">Recruté</span>
                                       @endif
                                       </div>
                                   </td>
                                   <td>
                                       <div class="pgde-candidate-actions">
                                           @if($u->userdata)
                                               <a class="is-view" href="{{ route('resume', $u->id) }}" aria-label="Voir {{ $u->firstname }} {{ $u->lastname }}" title="Voir"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                           @else
                                               <a class="is-view" href="{{ route('admin.edit', $u->id) }}" aria-label="Voir le compte de {{ $u->firstname }} {{ $u->lastname }}" title="Voir le compte"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                           @endif
                                           <a class="is-edit" href="{{ route('admin.edit', $u->id) }}" aria-label="Modifier {{ $u->firstname }} {{ $u->lastname }}" title="Modifier"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                           @unless($u->hasVerifiedEmail())
                                               <form action="{{ route('admin.users.resend-verification', $u->id) }}" method="POST" data-confirm-action data-confirm-title="Renvoyer le mail d’activation ?" data-confirm-description="Un nouveau lien d’activation sera envoyé à cette adresse :" data-confirm-value="{{ $u->email }}" data-confirm-label="Envoyer le mail" data-confirm-icon="fa-paper-plane">
                                                   @csrf
                                                   <button class="is-resend" type="submit" aria-label="Renvoyer le mail d’activation à {{ $u->email }}" title="Renvoyer le mail d’activation"><i class="fas fa-paper-plane" aria-hidden="true"></i></button>
                                               </form>
                                           @else
                                               <span class="pgde-candidate-action-placeholder" aria-hidden="true"></span>
                                           @endunless
                                           @if($u->enabled && $u->userdata && !$u->recruted)
                                               <form action="{{ route('admin.recruter', $u->id) }}" method="POST" data-confirm-action data-confirm-title="Confirmer le recrutement ?" data-confirm-description="Ce candidat sera marqué comme recruté dans la liste." data-confirm-value="{{ trim($u->firstname . ' ' . $u->lastname) ?: $u->username }}" data-confirm-label="Confirmer le recrutement" data-confirm-icon="fa-briefcase">
                                                   @csrf
                                                   <button class="is-recruit" type="submit" aria-label="Marquer {{ $u->firstname }} {{ $u->lastname }} comme recruté" title="Marquer comme recruté"><i class="fas fa-briefcase" aria-hidden="true"></i></button>
                                               </form>
                                           @else
                                               <span class="pgde-candidate-action-placeholder" aria-hidden="true"></span>
                                           @endif
                                       </div>
                                   </td>
                               </tr>
                               @empty
                               <tr><td colspan="6" class="pgde-candidate-empty">Aucun demandeur ne correspond à ces filtres.</td></tr>
                               @endforelse
                           </tbody>
                       </table>
                   </div>
                   <div class="pgde-candidate-pager">
                       <span>{{ $utilisateurs->firstItem() ?? 0 }}–{{ $utilisateurs->lastItem() ?? 0 }} sur {{ number_format($utilisateurs->total(), 0, ',', ' ') }}</span>
                       {{ $utilisateurs->onEachSide(1)->links('admin.partials.pagination') }}
                   </div>
               </section>
               <!-- jsPDF for PDF export -->
               <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
               <!-- SheetJS for Excel export -->
               <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
               <script>
                 // Export to Excel
                 document.getElementById('exportExcel').addEventListener('click', function() {
                     const table = document.getElementById('mainUserTable');
                     const wb = XLSX.utils.table_to_book(table, { sheet: 'Sheet 1' });
                     XLSX.writeFile(wb, 'utilisateurs.xlsx');
                 });
               </script>
           </div>
       </div>
       <!-- Fin contenu principal -->


       <!-- Footer -->
       <footer class="footer">
           <div class="container-fluid d-flex justify-content-center">
               <div class="copyright text-center">
                   © 2024 Copyright MFPRSP
               </div>
           </div>
       </footer>
       <!-- End Footer -->
   </div>
</div>


<!-- Scripts Core -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/pgde-admin.js') }}?v=settings-dropdown-v1"></script>


<!-- jQuery Scrollbar -->
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>


<!-- Chart JS -->
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>


<!-- jQuery Sparkline -->
<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>


<!-- Chart Circle -->
<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>


<!-- DataTables (JS) -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>


<!-- Kaiadmin DEMO methods -->
<script src="{{ asset('assets/js/setting-demo.js') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>


<!-- Scripts Sparkline -->
<script>
  $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#177dff",
    fillColor: "rgba(23, 125, 255, 0.14)",
  });


  $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#f3545d",
    fillColor: "rgba(243, 84, 93, .14)",
  });


  $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#ffa534",
    fillColor: "rgba(255, 165, 52, .14)",
  });
</script>


<!-- Initialisation DataTables -->
<script>
$(document).ready(function() {
  $('#mainUserTable').DataTable({
    language: {
      sProcessing:     "Traitement en cours...",
      sSearch:         "Rechercher&nbsp;:",
      sLengthMenu:     "Afficher _MENU_ éléments",
      sInfo:           "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
      sInfoEmpty:      "Affichage de 0 à 0 sur 0 élément",
      sInfoFiltered:   "(filtré de _MAX_ éléments au total)",
      sLoadingRecords: "Chargement en cours...",
      sZeroRecords:    "Aucun élément à afficher",
      sEmptyTable:     "Aucune donnée disponible dans le tableau",
      oPaginate: {
          sFirst:    "⏮",
          sPrevious: "←",
          sNext:     "→",
          sLast:     "⏭"
      }
    },
    lengthMenu: [10, 25, 50, 100],
    pageLength: 10,
    paging: false,
    info: false,
    lengthChange: false,
    searching: false,
    ordering: false,
    dom: "t"
  });
});
</script>



    <div class="pgde-action-modal" id="pgdeActionConfirmModal" hidden>
        <button class="pgde-action-modal-backdrop" type="button" data-action-cancel aria-label="Fermer la confirmation"></button>
        <section class="pgde-action-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="pgdeActionConfirmTitle" aria-describedby="pgdeActionConfirmDescription">
            <span class="pgde-action-modal-icon"><i class="fas fa-paper-plane" id="pgdeActionConfirmIcon" aria-hidden="true"></i></span>
            <h2 id="pgdeActionConfirmTitle"></h2>
            <p id="pgdeActionConfirmDescription"></p>
            <strong class="pgde-action-modal-address" id="pgdeActionConfirmValue"></strong>
            <div class="pgde-action-modal-actions">
                <button class="pgde-action-modal-cancel" type="button" data-action-cancel>Annuler</button>
                <button class="pgde-action-modal-confirm" type="button" id="pgdeActionConfirmButton"><i class="fas fa-check" aria-hidden="true"></i> <span id="pgdeActionConfirmLabel"></span></button>
            </div>
        </section>
    </div>
    <script>
        (() => {
            const toggle = document.getElementById('pgdeAdvancedToggle');
            const panel = document.getElementById('pgdeAdvancedFilters');
            if (!toggle || !panel) return;

            toggle.addEventListener('click', () => {
                const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', String(!isExpanded));
                toggle.classList.toggle('is-open', !isExpanded);
                panel.hidden = isExpanded;
            });
        })();
    </script>
    <script>
        (() => {
            const modal = document.getElementById('pgdeActionConfirmModal');
            const title = document.getElementById('pgdeActionConfirmTitle');
            const description = document.getElementById('pgdeActionConfirmDescription');
            const value = document.getElementById('pgdeActionConfirmValue');
            const icon = document.getElementById('pgdeActionConfirmIcon');
            const label = document.getElementById('pgdeActionConfirmLabel');
            const confirmButton = document.getElementById('pgdeActionConfirmButton');
            let activeForm = null;
            let triggerButton = null;

            document.querySelectorAll('form[data-confirm-action]').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    activeForm = form;
                    triggerButton = event.submitter || form.querySelector('button[type="submit"]');
                    title.textContent = form.dataset.confirmTitle;
                    description.textContent = form.dataset.confirmDescription;
                    value.textContent = form.dataset.confirmValue;
                    label.textContent = form.dataset.confirmLabel;
                    icon.className = `fas ${form.dataset.confirmIcon}`;
                    modal.hidden = false;
                    confirmButton.disabled = false;
                    document.body.classList.add('pgde-action-modal-open');
                    modal.querySelector('[data-action-cancel]').focus();
                });
            });

            const closeModal = () => {
                modal.hidden = true;
                document.body.classList.remove('pgde-action-modal-open');
                activeForm = null;
                if (triggerButton) triggerButton.focus();
            };

            modal.querySelectorAll('[data-action-cancel]').forEach((button) => button.addEventListener('click', closeModal));
            confirmButton.addEventListener('click', () => {
                if (!activeForm) return;
                confirmButton.disabled = true;
                activeForm.submit();
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.hidden) closeModal();
            });
        })();
    </script>
</body>
</html>
