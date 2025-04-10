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
     /* Conteneur du champ de recherche */
     div.dataTables_filter {
         text-align: right;
         margin-bottom: 20px;
     }


     /* Champ de recherche stylisé (loupe, arrondi...) */
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


     /* Effet focus */
     div.dataTables_filter input:focus {
         border-color: #28a745;
         box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
         outline: none;
     }


     /* Sur petit écran, centrer le champ */
     @media (max-width: 768px) {
         div.dataTables_filter {
             text-align: center;
         }


         div.dataTables_filter input {
             width: 90%;
             max-width: 100%;
         }
     }


     /* Pagination plus fun */
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


     /* Informations (x à y sur z) */
     .dataTables_info {
         font-size: 0.95rem;
         color: #555;
     }


     /* Choix du nombre d'éléments */
     .dataTables_length select {
         border-radius: 10px;
         padding: 4px 8px;
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
               <!-- Logo -->
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
                       <i class="fas fa-home"></i>   <span class="btn-text">   Accueil</span>
                           </a>
                 
                   </li>
                   <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="far fa-chart-bar"></i>
                  <p >Statistique</p>
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
                           <a class="nav-link dropdown-toggle profile-pic d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                               <span class="profile-username" style="color:black"  >
                                   <span class="op-7">Bienvenue</span>
                                
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


               <!-- Liste des demandeurs -->
               <div class="row">
                   <div id="mainTable" style="margin-top: 20px;">
                       <h4 class="text-center">Liste des demandeurs feminins</h4>


                       <div class="table-responsive">
                           <table class="table table-striped table-bordered table-hover" id="mainUserTable">
                               <thead class="thead-dark">
                                   <tr>
                                   <th>Numero dossier</th>
                                       <th>Prénom Nom</th>
                                       <th>Nom d'utilisateur</th>
                                       <th>CNI/Passport</th>
                                       <th>Email</th>
                                   
                                       <th>Action</th>
                                   </tr>
                               </thead>
                               <tbody>
                                
    @foreach($demandeursFeminins as $u)
                                   <tr>
                                   <td>{{ $u->id }}</td>
                                       <td>{{ $u->firstname }} {{ $u->lastname }}</td>
                                       <td>{{ $u->username }}</td>
                                       <td>{{ $u->numberid }}</td>
                                       <td>{{ $u->email }}</td>
                                      
                                       <td>
                                       <a href="{{ route('admin.editfeminin', $utilisateur->id) }}" class="btn btn-success">
                                       <i class="fas fa-edit"></i> Éditer
                                           </a>
                                       </td>
                                   </tr>
                                   @endforeach
                               </tbody>
                           </table>
                       </div> <!-- table-responsive -->
                   </div>
               </div>
               <!-- Fin de row -->
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


<!-- Kaiadmin DEMO methods (éventuellement à retirer en prod) -->
<script src="{{ asset('assets/js/setting-demo.js') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>


<!-- Scripts Sparkline (existant) -->
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


</body>
</html>


