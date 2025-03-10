<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Right Resume</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin"/>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap" media="print" onload="this.media='all'"/>
    <noscript>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap"/>
    </noscript>
    <link href="{{ asset('css/font-awesome/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/aos.css') }}" rel="stylesheet">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
   <noscript>
      <style type="text/css">
        [data-aos] {
            opacity: 1 !important;
            transform: translate(0) scale(1) !important;
        }
      </style>
    </noscript>
  </head>
  <body id="top">
    
    <header class="d-print-none">
    
<div class="d-flex justify-content-end">
<div class="dropdown">
    <button class="btn btn-light dropdown-toggle border" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="site-title mb-0">{{ $userdata->utilisateur->firstname }} {{ $userdata->utilisateur->lastname }}</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="{{ route('login') }}" class="dropdown-item">
                Déconnexion
            </a>
            <form id="logout-form" action="{{ route('login') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>

   </div>
</div>


<h1></h1>
<div class="d-flex justify-content-end">
  
</div>
    </header>
    <div class="page-content">
      <div class="container">
  <a class="btn btn-light border" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
           <span class="underline-text">INSCRIPTION N°: {{ $userdata->utilisateur->id }}</span>
       </a>
<div class="cover shadow-lg bg-white">
  <div class="cover-bg p-3 p-lg-4 text-white">
  
    <div class="row">
      <div class="col-lg-4 col-md-5">
        <div class="avatar hover-effect bg-white shadow-sm p-1">
               <img src="{{ asset($userdata->photo_profil ? $userdata->photo_profil : 
            'images/images.png') }}" alt="Photo de profil" width="200" height="200">

        </div>
      </div>
    
    </div>
    
  </div>
 <h1>&nbsp;</h1>
 &nbsp;

 <a href="{{ route('userdata.edit', ['id' => $userdata->id]) }}" class="btn btn-success">
    <i class="fas fa-edit me-2"></i> Mettre à jour mes infos
</a>

<style>
    .avatar img {
    filter: none; /* Supprime les filtres comme le noir et blanc */
}

</style>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
   <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
       <div class="d-flex">
           <div class="toast-body">
               {{ session('success') }}
           </div>
           <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
       </div>
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
       @if(session('success'))
           Swal.fire({
               icon: 'success',
               title: 'Succès !',
               text: "{{ session('success') }}",
               timer: 3000, // Disparait après 3 secondes
               showConfirmButton: false
           });
       @endif
   });
</script>

  <div class="about-section pt-4 px-3 px-lg-4 mt-1">
  <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="h3 mb-4 font-weight-bold text-primary">Informations personnelles</h2>
        </div>
   
      <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Date de naissance :</strong> <span class="text-secondary">{{ $userdata->datenaiss }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Email :</strong> <span class="text-secondary">{{ $userdata->utilisateur->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Téléphone :</strong> <span class="text-secondary">{{ $userdata->telephone1 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Lieu de résidence :</strong> <span class="text-secondary">{{ $userdata->lieuresidence }}</span>
                        </li>
                    </ul>
    </div>
  </div>


  <hr class="d-print-none"/>
  <div class="page-break"></div>
  <div class="about-section pt-4 px-3 px-lg-4 mt-1">
  <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="h3 mb-4 font-weight-bold text-primary">Formation</h2>
        </div>
    
        
        </div>
    <div class="timeline">
    <div class="timeline-card timeline-card-success card shadow-sm">
    <div class="card-body">
        <div class="h5 mb-1">
            {{ $userdata->academic->libelle ?? 'Non renseigné' }} 
            <span class="text-muted h6">à {{ $userdata->etablissementdiplome }}</span>
        </div>
        <div class="text-muted text-small mb-2">{{ $userdata->anneediplome }}</div>
        <div class="text-muted text-small mb-2"><strong>Intitulé du diplôme :</strong> {{ $userdata->diplome ?? 'Non renseigné' }}</div>
        <div class="text-muted text-small mb-2"><strong>Spécialité :</strong> {{ $userdata->specialite ?? 'Non renseigné' }}</div>
       
    </div>
</div>

    
    </div>
  </div>
 

  <div class="work-experience-section px-3 px-lg-4">
  <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="h3 mb-4 font-weight-bold text-primary">Expérience professionnelle</h2>
        </div>
    
        
   
    <div class="timeline">
      <div class="timeline-card timeline-card-primary card shadow-sm">
        <div class="card-body">
          <div class="h5 mb-1">{{ $userdata->posteoccupe }} <span class="text-muted h6">à {{ $userdata->employeur }}</span></div>
          <div class="text-muted text-small mb-2">{{ $userdata->nombreanneeexpe }}</div>
          <div>{{ $userdata->experiences }} </div>
        </div>
      </div>
    
    </div>
  </div>
 
 
</div>
<div class="work-experience-section px-3 px-lg-4">
  <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="h3 mb-4 font-weight-bold text-primary">Emploi</h2>
        </div>
    
        
   
    <div class="timeline">
    <div class="timeline-card timeline-card-orange card shadow-sm mb-4">
    <div class="card-body">
        <!-- Section Résumé du CV -->
        <div class="mb-4">
            <h6 class="text-uppercase font-weight-bold text-primary">Résumé du CV :</h6>
            <p class="text-muted">{{ $userdata->cv_summary }}</p>
        </div>

        <!-- Premier secteur et emploi -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-2">
                    <div class="h6 font-weight-semibold">Premier secteur choisi :</div>
                    <div class="text-muted">{{ $userdata->emploi1->secteur->libelle }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2">
                    <div class="h6 font-weight-semibold">Emploi concerné :</div>
                    <div class="text-muted">{{ $userdata->emploi1->libelle }}</div>
                </div>
            </div>
        </div>

        <!-- Deuxième secteur et emploi -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-2">
                    <div class="h6 font-weight-semibold">Deuxième secteur choisi :</div>
                    <div class="text-muted">{{ $userdata->emploi2->secteur->libelle }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2">
                    <div class="h6 font-weight-semibold">Emploi concerné :</div>
                    <div class="text-muted">{{ $userdata->emploi2->libelle }}</div>
                </div>
            </div>
        </div>

    </div>
</div>


  </div>
</div>

    </div>
    <footer class="pt-4 pb-4 text-muted text-center d-print-none">
   
    </footer>
    <script src="{{ asset('scripts/bootstrap.bundle.min.js?ver=1.2.0')}}"></script>
  
    <script src="{{ asset('scripts/aos.js?ver=1.2.0')}}"></script>
    <script src="{{ asset('scripts/main.js?ver=1.2.0')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>