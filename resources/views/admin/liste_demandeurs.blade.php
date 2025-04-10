<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <title>Liste des Demandeurs - Bootstrap 5 Admin Dashboard</title>
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


   <!-- Webfont -->
   <script src="assets/js/plugin/webfont/webfont.min.js"></script>
   <script>
     WebFont.load({
       google: { families: ["Public Sans:300,400,500,600,700"] },
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
<div class="wrapper">
   <!-- Sidebar -->
   <div class="sidebar" data-background-color="dark">
       <div class="sidebar-logo">
           <!-- Logo Header -->
           <div class="logo-header" data-background-color="dark">
               <a href="index.html" class="logo"></a>
               <img src="/images/logogris.png" alt="" style="height: 70px; margin-top:20px; margin-right:50px">
               <div class="nav-toggle">
                   <button class="btn btn-toggle toggle-sidebar">
                       <i class="gg-menu-right"></i>
                   </button>
                   <button class="btn btn-toggle sidenav-toggler">
                       <i class="gg-menu-left"></i>
                   </button>
               </div>
               <button class="topbar-toggler more">
                   <i class="gg-more-vertical-alt"></i>
               </button>
           </div>
           <!-- End Logo Header -->
       </div>
       <div class="sidebar-wrapper scrollbar scrollbar-inner">
           <div class="sidebar-content">
               <ul class="nav nav-secondary">
                   <li class="nav-item active">
                       <a href="{{ route('admin.users') }}" class="btn-choose-theme">
                           <i class="fas fa-home"></i>
                           <span class="btn-text"> Accueil</span>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="#">
                           <i class="far fa-chart-bar"></i>
                           <p>Statistique</p>
                       </a>
                   </li>
               </ul>
           </div>
       </div>
   </div>
   <!-- End Sidebar -->


   <div class="main-panel">
       <div class="main-header">
           <div class="main-header-logo">
               <!-- Logo Header -->
               <div class="logo-header" data-background-color="dark">
                   <a href="index.html" class="logo">
                       <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20"/>
                   </a>
                   <div class="nav-toggle">
                       <button class="btn btn-toggle toggle-sidebar">
                           <i class="gg-menu-right"></i>
                       </button>
                       <button class="btn btn-toggle sidenav-toggler">
                           <i class="gg-menu-left"></i>
                       </button>
                   </div>
                   <button class="topbar-toggler more">
                       <i class="gg-more-vertical-alt"></i>
                   </button>
               </div>
               <!-- End Logo Header -->
           </div>


           <!-- Navbar Header -->
           <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
               <div class="container-fluid">
                   <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                       <!-- Dropdown Utilisateur avec Déconnexion -->
                       <li class="nav-item dropdown hidden-caret">
                           <a class="nav-link dropdown-toggle profile-pic d-flex align-items-center"
                              href="#"
                              id="userDropdown"
                              role="button"
                              data-bs-toggle="dropdown"
                              aria-expanded="false">
                               <span class="profile-username" style="color:black">
                                   <span class="op-7">Bienvenue,</span>
                                   <span class="fw-bold">
                                       {{ $utilisateur->firstname }} {{ $utilisateur->lastname }}
                                   </span>
                               </span>
                               <i class="fa fa-caret-down ms-2"></i> <!-- Flèche vers le bas -->
                           </a>
                           <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                               <li>
                                   <a class="dropdown-item text-danger" href="/admin/login">
                                       <i class="fa fa-sign-out-alt me-2"></i> Déconnexion
                                   </a>
                               </li>
                           </ul>
                       </li>
                   </ul>
               </div>
           </nav>
           <!-- End Navbar -->
       </div>


       <!-- Contenu principal -->
       <div class="container">
           <div class="page-inner">
               <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                   <div>
                       <h3 class="fw-bold mb-3">
                           <i class="fas fa-home"></i>
                           <a href="{{ route('admin.users') }}" class="btn-choose-theme">
                               <span class="btn-text">Dashboard</span>
                           </a>
                       </h3>
                   </div>
               </div>


               <!-- Lignes: Export à gauche, Filtre à droite -->
               <div class="row mb-3">
                 <div class="col-md-6 d-flex align-items-start">
                   <!-- Bouton d'export Excel -->
                   <a class="btn btn-primary" id="exportExcel">
                     <i class="fa fa-file-excel"></i> Exporter en Excel
                   </a>
                 </div>
                 <div class="col-md-6 d-flex justify-content-end">
                   <!-- Bouton Filtre -->
                   <div class="dropdown d-inline-block">
                     <button class="btn btn-outline-primary dropdown-toggle" type="button"
                             id="filterDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="fas fa-filter"></i> Filtres
                     </button>
                     <div class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="filterDropdownBtn"
                          id="filterMenu" style="min-width: 220px;">
                       <label class="dropdown-item">
                         <input type="checkbox" value="id" /> Numéro FP
                       </label>
                       <label class="dropdown-item">
                         <input type="checkbox" value="identity_number" /> Numéro d'identité
                       </label>
                       <label class="dropdown-item">
                         <input type="checkbox" value="username" /> Nom d'utilisateur
                       </label>
                       <label class="dropdown-item">
                         <input type="checkbox" value="email" /> Adresse e-mail
                       </label>
                       <label class="dropdown-item">
                         <input type="checkbox" value="firstname" /> Prénom
                       </label>
                       <label class="dropdown-item">
                         <input type="checkbox" value="lastname" /> Nom
                       </label>
                       <label class="dropdown-item">
                         <input type="checkbox" value="isActif" /> Actif
                       </label>
                       <label class="dropdown-item">
                         <input type="checkbox" value="isRecruted" /> Recruté
                       </label>
                     </div>
                   </div>
                 </div>
               </div>


               <!-- Formulaire de recherche -->
               <form action="{{ route('admin.liste_utiliateurs') }}" method="GET" class="mt-3">

                 <div id="dynamicFilterForm">
                   <!-- Les champs s'ajoutent en vertical (un par bloc) -->
                 </div>
                 <div class="d-flex justify-content-end mt-3">
                   <button type="submit" class="btn btn-success me-2">
                     <i class="fas fa-search"></i> Rechercher
                   </button>
                   <button type="button" class="btn btn-secondary" id="resetFilters">
  Réinitialiser
</button>

                 </div>
               </form>
                   <h1></h1>
               <!-- Script : ajout des champs verticalement + bouton "moins" -->
               <script>
 const filterMenu = document.getElementById('filterMenu');
 const dynamicFilterForm = document.getElementById('dynamicFilterForm');


 filterMenu.addEventListener('change', function(e) {
   if (e.target.type === 'checkbox') {
     const fieldName = e.target.value;
     const fieldId = 'filter-' + fieldName;
     const existingField = document.getElementById(fieldId);


     if (e.target.checked) {
       const wrapper = document.createElement('div');
       wrapper.className = 'd-flex align-items-center mb-2';
       wrapper.id = fieldId;


       let labelTxt = fieldName;
       if (fieldName === 'isActif') labelTxt = 'Actif ?';
       if (fieldName === 'isRecruted') labelTxt = 'Recruté ?';


       let inputGroup = '';


       if (fieldName === 'isActif' || fieldName === 'isRecruted') {
         inputGroup = `
           <label class="fw-bold me-2" style="width: 120px;">${labelTxt}</label>
           <select name="${fieldName}" class="form-control me-2" style="max-width: 200px;">
             <option value="">-- Choisir --</option>
             <option value="1">Oui</option>
             <option value="0">Non</option>
           </select>
         `;
       } else {
         inputGroup = `
           <label class="fw-bold me-2" style="width: 120px;">${labelTxt}</label>
           <input type="text" name="${fieldName}" class="form-control me-2" placeholder="${labelTxt}" style="max-width: 200px;" />
         `;
       }


       // Crée un div temporaire pour injecter HTML
       wrapper.innerHTML = inputGroup;


       const minusBtn = document.createElement('button');
       minusBtn.type = 'button';
       minusBtn.className = 'btn btn-outline-danger btn-sm';
       minusBtn.innerHTML = `<i class="fas fa-minus"></i>`;


       // Quand on clique sur le bouton moins
       minusBtn.addEventListener('click', function () {
         // décocher la checkbox correspondante
         const checkbox = filterMenu.querySelector(`input[value="${fieldName}"]`);
         if (checkbox) checkbox.checked = false;
         wrapper.remove();
       });


       wrapper.appendChild(minusBtn);
       dynamicFilterForm.appendChild(wrapper);


     } else {
       if (existingField) existingField.remove();
     }
   }
 });
</script>


               <!-- Tableau principal -->
               <div class="table-responsive">
                   <table class="table table-striped table-bordered table-hover" id="mainUserTable">
                       <thead class="thead-dark">
                           <tr>
                               <th>Numéro FP</th>
                               <th>Prénom Nom</th>
                               <th>Nom d'utilisateur</th>
                               <th>CNI/Passport</th>
                               <th>Email</th>
                               <th>Enabled</th>
                               <th>Recruted</th>
                               <th>Détails</th>
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach($utilisateurs as $u)
                           <tr>
                               <td>{{ $u->id }}</td>
                               <td>{{ $u->firstname }} {{ $u->lastname }}</td>
                               <td>{{ $u->username }}</td>
                               <td>{{ $u->numberid }}</td>
                               <td>{{ $u->email }}</td>
                               <td>
                                   @if ($u->enabled)
                                       <span class="badge bg-success text-white">oui</span>
                                   @else
                                       <span class="badge bg-danger text-white">non</span>
                                   @endif
                               </td>
                               <td>
                                   @if ($u->recruted)
                                       <span class="badge bg-success text-white">oui</span>
                                   @else
                                       <span class="badge bg-danger text-white">non</span>
                                   @endif
                               </td>
                               <td class="align-middle">
                                   <a href="{{ route('resume', $u->id) }}" class="btn btn-info btn-sm m-1">
                                       <i class="fas fa-eye"></i>
                                   </a>
                               </td>
                               <td>
                                   <a href="{{ route('admin.edit', $u->id) }}" class="btn btn-success">
                                       <i class="fas fa-edit"></i>
                                   </a>
                               </td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
               <div class="d-flex justify-content-center mt-4">
    {{ $utilisateurs->links('pagination::bootstrap-5') }}
</div>



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
    dom:
      "<'row mb-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
      "<'table-responsive'tr>" +
      "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
  });
});
</script>
<script>
  document.getElementById('resetFilters').addEventListener('click', function () {
    // 1. Réinitialiser les champs dynamiques
    document.getElementById('dynamicFilterForm').innerHTML = '';

    // 2. Décocher toutes les cases à cocher du menu
    const checkboxes = filterMenu.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => cb.checked = false);

    // 3. Soumettre le formulaire sans filtres
    document.querySelector('form').submit();
  });
</script>


</body>
</html>

