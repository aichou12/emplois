<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> PGDE</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="/images/logogris.png"
      type="image/x-icon"/>
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
            <img src="/images/logogris.png" alt="" style="height: 70px;margin-top:20px;margin-right:50px">
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
            <li class="nav-item dropdown hidden-caret" >
                <a class="nav-link dropdown-toggle profile-pic d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="profile-username">
                        <span class="op-7"  style="color:black">Bienvenue</span>
                       <!--  <span class="fw-bold"> {{ $utilisateur->firstname }} {{ $utilisateur->lastname }}</span>-->
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
                <h3 class="fw-bold mb-3"><i class="fas fa-home"></i><a href="/demandeurincomplet" class="btn-choose-theme">
                        <span class="btn-text">Dashboard</span>
                      </a></h3>

              </div>

            </div>
            <!-- Formulaire de recherche -->
<!-- Champ de recherche et bouton -->



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

<div class="sticky-wrapper" style=""><nav class="navbar navbar-default" role="navigation" style="width: auto;">
 <div class="container-fluid">

    <div class="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
        <li>
  <a class="sonata-action-element d-flex align-items-center" href="/demandeurincomplet">
    <i class="fas fa-arrow-left me-2"></i> Retourner à la liste
  </a>
</li>

    </ul>

    </div>
    </div>
 </nav></div>

 </div>
 <style>
  .success-message {
    background-color: #28a745; /* Vert */
    color: white; /* Texte en blanc */
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;
}

 </style>
@if(session('success'))
    <div class="success-message" id="success-message">
        {{ session('success') }}
    </div>

    <script>
        // Attendre que le DOM soit prêt
        document.addEventListener('DOMContentLoaded', function () {
            // Cibler le message de succès
            var successMessage = document.getElementById('success-message');

            // Vérifier si l'élément existe
            if (successMessage) {
                // Ajouter un délai de 3 secondes (3000 ms) avant de le faire disparaître
                setTimeout(function () {
                    successMessage.style.transition = "opacity 0.5s"; // Ajoute une transition pour la disparition
                    successMessage.style.opacity = 0; // Rendre le message transparent

                    // Après la transition, supprimer l'élément du DOM
                    setTimeout(function () {
                        successMessage.remove();
                    }, 500); // Délai pour correspondre à la transition
                }, 3000); // 3 secondes
            }
        });
    </script>
@endif



 <div class="col-md-12">
                <div class="card">
                  <div class="card-header">




                <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">
  <i class="fas fa-edit"></i>
  Éditer les informations de l'utilisateur
</h4>



                </div>
                <div class="card-body">
                <form id="updateForm" action="{{ route('admin.updateincomplet', $utilisateur->id) }}" method="POST">
        @csrf
        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">CNI/Passport</label>
                                    <input type="text" name="numberid" class="form-control" value="{{ $utilisateur->numberid }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nom d'utilisateur</label>
                                    <input type="text" name="username" class="form-control" value="{{ $utilisateur->username }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" name="firstname" class="form-control" value="{{ $utilisateur->firstname }}" required>
                                </div>
                                <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Adresse e-mail</label>
                                    <input type="email" name="email" class="form-control" value="{{ $utilisateur->email }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Recruter</label>
                                    <input type="number" name="recruted" class="form-control" value="{{ $utilisateur->recruted }}" >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="lastname" class="form-control" value="{{ $utilisateur->lastname }}" required>
                                </div>

                            <div class="mb-3">
                                <label class="form-label">Répétez le mot de passe</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                                                    <small id="passwordMismatch" class="text-danger" style="display:none;">
                        Les mots de passe ne correspondent pas.
                        </small>




                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="text-end">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Mettre à jour</button>
                             </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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






<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('updateForm');
    const password = document.querySelector('input[name="password"]');
    const confirmPassword = document.querySelector('input[name="password_confirmation"]');

    form.addEventListener('submit', function (e) {
      if (password.value !== confirmPassword.value) {
        e.preventDefault(); // Stop le formulaire
        alert("Les mots de passe ne correspondent pas !");
        confirmPassword.focus();
      }
    });
  });
</script>
<script>
    const message = document.getElementById('passwordMismatch');
form.addEventListener('submit', function (e) {
  if (password.value !== confirmPassword.value) {
    e.preventDefault();
    message.style.display = 'block';
  } else {
    message.style.display = 'none';
  }
});

</script>

    <footer class="footer">
            <div class="container-fluid d-flex justify-content-center">
                <div class="copyright text-center">
                    © 2024 Copyright MFPRSP
                </div>
            </div>
        </footer>
  </body>
</html>
