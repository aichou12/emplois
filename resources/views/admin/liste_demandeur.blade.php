<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Bootstrap 5 Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <!-- Fonts and icons -->
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

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
           
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
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Accueil</p>
               
                </a>
                <div class="collapse" id="dashboard">
                  
                </div>
              </li>
              
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-layer-group"></i>
                  <p>Utlisateurs</p>
                 
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
                <img
                  src="assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
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
                    <span class="profile-username">
                        <span class="op-7">Bonjour</span>
                        <span class="fw-bold"> {{ $utilisateur->firstname }} {{ $utilisateur->lastname }}</span>
                    </span>
                    <i class="fa fa-caret-down ms-2"></i> <!-- Icône flèche vers le bas -->
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('login') }}">
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

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>   
                <h3 class="fw-bold mb-3"><i class="fas fa-home"></i><a href="{{ route('admin.users') }}" class="btn-choose-theme">
                        <span class="btn-text">Dashboard</span>
                      </a></h3>
                
              </div>
             
            </div>
            <!-- Formulaire de recherche -->
<!-- Champ de recherche et bouton -->
<div class="d-flex justify-content-between mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un utilisateur..." />
    <button id="searchButton" class="btn btn-primary ms-2">Rechercher</button>
</div>


<!-- Message si aucun utilisateur trouvé -->
<div id="noResultsMessage" class="alert alert-warning" style="display: none;">
    Utilisateur non trouvé.
</div>


<!-- Tableau des utilisateurs -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchButton').addEventListener('click', function() {
        var searchQuery = document.getElementById('searchInput').value.toLowerCase();
        var noResults = true; // Variable pour vérifier s'il y a des résultats

        // Liste de tous les tableaux à rechercher
        var tables = ["mainTable", "recrutedTable", "notRecrutedTable"];

        tables.forEach(function(tableId) {
            var table = document.getElementById(tableId);
            var rows = table.querySelectorAll('tbody tr');

            // On parcourt toutes les lignes de chaque tableau
            rows.forEach(function(row) {
                var cells = row.getElementsByTagName('td');
                var found = false;

                // Parcours des cellules du tableau et vérification si la valeur de recherche existe
                for (var i = 0; i < cells.length; i++) {
                    if (cells[i].innerText.toLowerCase().includes(searchQuery)) {
                        found = true;
                        break;
                    }
                }

                // Afficher ou masquer la ligne en fonction de la recherche
                row.style.display = found ? '' : 'none';

                if (found) {
                    noResults = false; // Il y a des résultats
                }
            });
        });

        // Afficher ou masquer le message "Utilisateur non trouvé"
        document.getElementById('noResultsMessage').style.display = noResults ? 'block' : 'none';
    });
});

</script>


    

<!-- Script pour la recherche -->


            <div class="row">
     <!-- Utilisateurs Recrutés -->







    <script>
    function toggleTable(tableId) {
    // Masquer tous les tableaux
    var tables = document.querySelectorAll('.table-responsive');
    tables.forEach(function(table) {
        table.style.display = 'none';
    });

    // Afficher le tableau concerné
    var tableToShow = document.getElementById(tableId);
    if (tableToShow) {
        tableToShow.style.display = 'block';
    }
}

</script>

</div>

<!-- Tableau des utilisateurs recrutés -->


<!-- Script pour afficher/masquer les tableaux -->

</script>
<script>
    function toggleTable(tableId) {
        // Liste des tableaux
        var tables = ["mainTable","recrutedTable", "notRecrutedTable"];

        tables.forEach(function(id) {
            var table = document.getElementById(id);
            if (id === tableId) {
                // Si c'est le tableau cliqué, on l'affiche
                table.style.display = (table.style.display === "none" || table.style.display === "") ? "block" : "none";
            } else {
                // Sinon, on cache les autres tableaux
                table.style.display = "none";
            }
        });
    }
</script>



        
                     
                   

                    <div id="mainTable" style="margin-top: 20px;">
    <h4>Liste des demandeurs</h4>

       
<table class="table table-striped table-bordered table-hover"  id="mainUserTable">
    <thead class="thead-dark">
        <tr>
            <th>CNI/Passport</th>
  
            <th>Email</th>
            <th>Prénom Nom</th>
            <th>Détails</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($utilisateurs as $utilisateur)
        <tr>
            <td>{{ $utilisateur->numberid }}</td>
     
            <td>{{ $utilisateur->email }}</td>
            <td>{{ $utilisateur->firstname }} {{ $utilisateur->lastname }}</td>
            <td class="align-middle">
    <a href="{{ route('resume', $utilisateur->id) }}" class="btn btn-info btn-sm m-1">
        <i class="fas fa-eye"></i> Voir
    </a>
    
</td>
   <td>
   <a href="{{ route('admin.edit', $utilisateur->id) }}" class="btn btn-success">
   <i class="fas fa-edit"></i> Éditer
    </a>
                        
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

    </table>
</div>

                  </div>
                </div>
              </div>

      </div>
      <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">

                    <footer class="footer">
              <div class="container-fluid d-flex justify-content-center">
                  <div class="copyright text-center">
                      © 2024 Copyright MFPRSP
                  </div>
              </div>
          </footer>
      <!-- Custom template | don't include it in your project! -->
     
      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
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

<!-- Datatables -->
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->

<!-- jQuery Vector Maps -->
<script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Kaiadmin JS -->

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{ asset('assets/js/setting-demo.js') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>

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
  </body>
</html>
