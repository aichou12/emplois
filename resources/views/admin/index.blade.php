<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>PGDE</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"/>
    <link
      rel="icon"
      href="/assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Fonts and icons -->
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
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
          urls: ["/assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>
<style>
  /* General Styles for the grid */
.theme-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
    justify-items: center;
    background-color: #f4f7fc;
}

/* Theme card styling */
.theme-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    max-width: 300px;
    width: 100%;
}
.theme-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 colonnes fixes */
            gap: 20px;
            padding: 20px;
            justify-items: center;
            background-color: #f4f7fc;
        }
/* Add hover effects */
.theme-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Theme icons */
.theme-icon {
    font-size: 3rem;
    color: #4e73df;
    transition: color 0.3s ease;
}

/* Change color on hover */
.theme-card:hover .theme-icon {
    color: #2e59d9;
}

/* Title Styling */
.theme-card h4 {
    font-size: 1.4rem;
    font-weight: bold;
    margin: 10px 0;
    color: #333;
}

/* Paragraph Styling */
.theme-card p {
    font-size: 1rem;
    color: #666;
    margin: 10px 0;
}

/* Responsive adjustments */
@media screen and (max-width: 768px) {
    .theme-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }

    .theme-card {
        max-width: 260px;
    }
}

</style>
    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="/assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
          <h6 style="color:white"></h6>
          <img src="/assets/img/logg.PNG" alt="" style="height: 90px;margin-top:20px;margin-right:50px">


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
                <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                  <i class="fas fa-home"></i>
                <p>Accueil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#">
                  <i class="fas fa-user"></i>
                <p>Utilisateur</p>
            </a>
              </li><!-- End Logo Header
              <li class="nav-item">
          
                  <i class="fas fa-user"></i>
                <p>Utilisateur</p>
            </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="">
                  <i class="far fa-chart-bar"></i>
                  <p>Statistique</p>
                </a>
            </li>-->
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
                <img
                  src="/assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"/>
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
            <span class="op-7">Bienvenue,</span>
            <span class="fw-bold">{{ $utilisateur->firstname }} {{ $utilisateur->lastname }}</span>


              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">



                <div class="dropdown">
                  <button class="btn  dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>

                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <li><button class="dropdown-item" type="button"><a href="/admin/login">Deconnexion</button></li>
                  </ul>
                </div>

              </ul>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
          </nav>

      
        </div>
   



        <div class="container">
          <div class="page-inner">
           
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-icon">
                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Tous les utilisateurs</p>
                          <h4 class="card-title"> {{ $totalUsers }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-icon">
                    <div class="icon-big text-center icon-success bubble-shadow-small">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Utilisateurs Recrutés</p>
                          <h4 class="card-title">{{ $recrutedUsers }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-icon">
                    <div class="icon-big text-center icon-danger bubble-shadow-small">
                        <i class="fas fa-user-times"></i>
                    </div>
                </div>
                      <a href="" class="col col-stats ms-3 ms-sm-0 text-decoration-none text-dark">
    <div class="numbers">
        <p class="card-category">Utilisateurs Non Recrutés</p>
        <h4 class="card-title">{{ $notRecrutedUsers }}</h4>
    </div>
</a>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card card-round">
                  <div class="card-header">
                    <div class="card-head-row">
                      <div class="card-title">Statistique</div>
                      <div class="card-tools">
                        <a
                          href="#"
                          class="btn btn-label-success btn-round btn-sm me-2">
                          <span class="btn-label">
                            <i class="fa fa-pencil"></i>
                          </span>
                          Export
                        </a>
                        <a href="#" class="btn btn-label-info btn-round btn-sm">
                          <span class="btn-label">
                            <i class="fa fa-print"></i>
                          </span>
                          Print
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="container-fluid" style="min-height: 375px">

                 <div id="themeSelection" class="hidden-section mt-5">
            <div class="text-center mb-4">
            <!-- <h2 class="text-primary">Sur quelles thématiques souhaitez-vous donner votre avis ?</h2> -->

            </div>

            <!-- Cartes en grille (3 par ligne) -->
         <div class="theme-grid" id="themeCardsContainer">
    <!-- 1) Accès aux services publics -->
    <a href="/liste_demandeur" class="theme-card" data-theme="liste_demandeur">
    <h4>
    <i class="fas fa-user theme-icon animate__animated animate__heartBeat"></i>
    Liste des Demandeurs
</h4>

       <p><strong>Total : {{ $totalUsers }}</strong></p> <!-- Affichage du total -->
</a>

    <!-- 2) Accueil & orientation -->
  
    <!-- 3) Diligence -->
    <a href="/nombre_inscrit" class="theme-card" data-theme="nombre_inscrit">
        <h4>
        <i class="fas fa-users theme-icon animate__animated animate__heartBeat"></i>
        Nombre d'inscrits de l'année courant
        </h4>
        <p><strong>Total:{{ $currentYearUsers}} </strong></p> <!-- Affichage du total -->

        </a>

    <a href="/sans_diplome" class="theme-card" data-theme="sans_diplome">
        <h4>
               <i class="fas fa-question-circle theme-icon animate__animated animate__heartBeat"></i>

               Demandeur sans diplôme
        </h4>
        <p><strong>Total  :{{$sansdiplome}} </strong></p> <!-- Affichage du total -->
        </a>
        <a href="/avec_diplome" class="theme-card" data-theme="avec_diplome">
        <h4>
        <i class="fas fa-graduation-cap theme-icon animate__animated animate__bounce"></i>
        Demandeur avec diplôme
        </h4>
        <p><strong>Total:{{$avecdiplome}}</strong></p> <!-- Affichage du total -->
     </a>
    <!-- 7) Digitale -->
    <a href="/demandeur_masculin" class="theme-card" data-theme="demandeur_masculin">
    <h4>
    <i class="fas fa-male theme-icon animate__animated animate__heartBeat"></i>
    Demandeurs de sexe Masculin
</h4>

        <p><strong>Total:{{$totalMales}}</strong></p> <!-- Affichage du total -->
        </a>
    <!-- 8) Participation -->
    <a href="/demandeur_feminin" class="theme-card" data-theme="demandeur_feminin">
    <h4>
    <i class="fas fa-female theme-icon animate__animated animate__heartBeat"></i>
    Demandeurs de sexe Féminin
</h4>


        <p><strong>Total:{{$totalFemales}}</strong></p> <!-- Affichage du total -->
      </a>
    <!-- 9) Ressources Humaines -->
   
</div>








                        </body>
                        </html>

                      </table>
                    </div>
                    <div id="myChartLegend"></div>
                  </div>
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


          </div>
        </footer>
      </div>
    </div>
    <script src="/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="/assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="/assets/js/plugin/chart-circle/circles.min.js"></script>
    <script src="/assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="/assets/js/plugin/jsvectormap/world.js"></script>
    <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="/assets/js/kaiadmin.min.js"></script>
    <script src="/assets/js/setting-demo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  </body>
</html>
