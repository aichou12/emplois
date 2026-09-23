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

    @include('partials.user-header')

    <div class="page-content">
      <div class="container">
        <a class="btn btn-light border mb-3" type="button">
          <span class="underline-text">INSCRIPTION N°: {{ $userdata->utilisateur->id }}</span>
        </a>

        <div class="cover shadow-lg bg-white">
          <div class="cover-bg p-3 p-lg-4 text-white">
            <div class="row">
              <div class="col-lg-4 col-md-5">
                <div class="avatar hover-effect bg-white shadow-sm p-1">
                  <img id="user-photo" src="{{ asset($userdata->photo_profil ? $userdata->photo_profil : 'images/images.png') }}" alt="Photo de profil" width="200" height="200">
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <a href="{{ route('userdata.edit', ['id' => $userdata->id]) }}" class="btn btn-success">
              <i class="fas fa-edit me-2"></i> Mettre à jour mes infos
            </a>
          </div>

          <style>
            .avatar img {
              filter: none;
            }
          </style>

          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <script>
            document.addEventListener("DOMContentLoaded", function () {
              @if(session('success'))
                Swal.fire({
                  icon: 'success',
                  title: 'Succès !',
                  text: "{{ session('success') }}",
                  timer: 3000,
                  showConfirmButton: false
                });
              @endif
            });
          </script>

          <!-- Informations personnelles -->
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

          <!-- Formation -->
          <div class="about-section pt-4 px-3 px-lg-4 mt-1">
            <div class="row justify-content-center">
              <div class="col-md-8 text-center">
                <h2 class="h3 mb-4 font-weight-bold text-primary">Formation</h2>
              </div>
            </div>

            @php
              $formationsList = [];
              if (!empty($userdata->autresdiplomes)) {
                  $decodedForm = is_array($userdata->autresdiplomes)
                      ? $userdata->autresdiplomes
                      : json_decode($userdata->autresdiplomes, true);
                  if (is_array($decodedForm)) {
                      $formationsList = $decodedForm;
                  }
              }
              $academicMap = \App\Models\Academic::pluck('libelle', 'id')->toArray();

              // Décoder les fichiers joints
              $diplomeFiles = [];
              if (!empty($userdata->diplome_file)) {
                  $decoded = is_array($userdata->diplome_file)
                      ? $userdata->diplome_file
                      : json_decode($userdata->diplome_file, true);
                  if (is_array($decoded)) {
                      $diplomeFiles = $decoded;
                  } elseif (is_string($userdata->diplome_file)) {
                      $diplomeFiles = [$userdata->diplome_file];
                  }
              }
            @endphp

            <div class="timeline">
              @if(!empty($formationsList))
                @foreach($formationsList as $i => $form)
                  @php
                    $aid = $form['academic_id'] ?? null;
                    $levelName = ($aid === 'sansdiplome' || $aid === '20') ? 'Sans diplôme' : ($academicMap[$aid] ?? ($userdata->academic->libelle ?? 'Non renseigné'));
                    $fileForThisForm = $diplomeFiles[$i] ?? null;
                  @endphp
                  <div class="timeline-card timeline-card-success card shadow-sm mb-3">
                    <div class="card-body">
                      <div class="h5 mb-1">
                        {{ $levelName }}
                        @if(!empty($form['etablissementdiplome']))
                          <span class="text-muted h6">à {{ $form['etablissementdiplome'] }}</span>
                        @endif
                      </div>
                      @if(!empty($form['anneediplome']))
                        <div class="text-muted text-small mb-2">{{ $form['anneediplome'] }}</div>
                      @endif
                      @if(!empty($form['diplome']))
                        <div class="text-muted text-small mb-2"><strong>Intitulé du diplôme :</strong> {{ $form['diplome'] }}</div>
                      @endif
                      @if(!empty($form['specialite']))
                        <div class="text-muted text-small mb-2"><strong>Spécialité :</strong> {{ $form['specialite'] }}</div>
                      @endif
                      @if($fileForThisForm)
                        <div class="mt-2">
                          <a href="{{ asset($fileForThisForm) }}" target="_blank" class="btn btn-outline-success btn-sm d-inline-flex align-items-center">
                            <i class="fas fa-file-alt me-2"></i> {{ basename($fileForThisForm) }}
                            <i class="fas fa-external-link-alt ms-2 text-muted" style="font-size:0.75rem;"></i>
                          </a>
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach

                @php
                  // Fichiers supplémentaires sans formation correspondante
                  $extraFiles = array_slice($diplomeFiles, count($formationsList));
                @endphp
                @if(!empty($extraFiles))
                  <div class="card shadow-sm mb-3 border-0 bg-light">
                    <div class="card-body py-3">
                      <h6 class="text-uppercase font-weight-bold text-success mb-2">
                        <i class="fas fa-file-pdf me-1"></i> Autres pièces jointes :
                      </h6>
                      <div class="d-flex flex-wrap gap-2">
                        @foreach($extraFiles as $dFile)
                          <a href="{{ asset($dFile) }}" target="_blank" class="btn btn-outline-success btn-sm d-inline-flex align-items-center">
                            <i class="fas fa-file-alt me-2"></i> {{ basename($dFile) }}
                            <i class="fas fa-external-link-alt ms-2 text-muted" style="font-size:0.75rem;"></i>
                          </a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endif

              @elseif(!empty($userdata->academic_id) || !empty($userdata->diplome))
                <div class="timeline-card timeline-card-success card shadow-sm mb-3">
                  <div class="card-body">
                    <div class="h5 mb-1">
                      {{ $userdata->academic->libelle ?? 'Non renseigné' }}
                      @if(!empty($userdata->etablissementdiplome))
                        <span class="text-muted h6">à {{ $userdata->etablissementdiplome }}</span>
                      @endif
                    </div>
                    @if(!empty($userdata->anneediplome))
                      <div class="text-muted text-small mb-2">{{ $userdata->anneediplome }}</div>
                    @endif
                    @if(!empty($userdata->diplome))
                      <div class="text-muted text-small mb-2"><strong>Intitulé du diplôme :</strong> {{ $userdata->diplome }}</div>
                    @endif
                    @if(!empty($userdata->specialite))
                      <div class="text-muted text-small mb-2"><strong>Spécialité :</strong> {{ $userdata->specialite }}</div>
                    @endif
                    @if(!empty($diplomeFiles))
                      <div class="mt-2">
                        @foreach($diplomeFiles as $dFile)
                          <a href="{{ asset($dFile) }}" target="_blank" class="btn btn-outline-success btn-sm d-inline-flex align-items-center me-1 mb-1">
                            <i class="fas fa-file-alt me-2"></i> {{ basename($dFile) }}
                            <i class="fas fa-external-link-alt ms-2 text-muted" style="font-size:0.75rem;"></i>
                          </a>
                        @endforeach
                      </div>
                    @endif
                  </div>
                </div>
              @else
                <p class="text-muted text-center">Aucune formation renseignée.</p>
              @endif
            </div>
          </div>

          <!-- Expérience professionnelle -->
          <div class="work-experience-section px-3 px-lg-4">
            <div class="row justify-content-center">
              <div class="col-md-8 text-center">
                <h2 class="h3 mb-4 font-weight-bold text-primary">Expérience professionnelle</h2>
              </div>
            </div>

            @php
              $experiencesList = [];
              if (!empty($userdata->experiences)) {
                  $decoded = is_array($userdata->experiences) 
                      ? $userdata->experiences 
                      : json_decode($userdata->experiences, true);
                  if (is_array($decoded)) {
                      $experiencesList = $decoded;
                  }
              }
            @endphp

            <div class="timeline">
              @if(!empty($experiencesList))
                @foreach($experiencesList as $exp)
                  <div class="timeline-card timeline-card-primary card shadow-sm mb-3">
                    <div class="card-body">
                      <div class="h5 mb-1">{{ $exp['poste'] ?? $userdata->posteoccupe }} @if(!empty($exp['employeur']))<span class="text-muted h6">à {{ $exp['employeur'] }}</span>@endif</div>
                      @if(!empty($exp['years']))
                        <div class="text-muted text-small mb-2">{{ $exp['years'] }} an(s) d'expérience</div>
                      @endif
                      @if(!empty($exp['description']))
                        <div>{{ $exp['description'] }}</div>
                      @endif
                    </div>
                  </div>
                @endforeach
              @elseif(!empty($userdata->posteoccupe) || !empty($userdata->employeur))
                <div class="timeline-card timeline-card-primary card shadow-sm mb-3">
                  <div class="card-body">
                    <div class="h5 mb-1">{{ $userdata->posteoccupe }} @if(!empty($userdata->employeur))<span class="text-muted h6">à {{ $userdata->employeur }}</span>@endif</div>
                    @if(!empty($userdata->nombreanneeexpe))
                      <div class="text-muted text-small mb-2">{{ $userdata->nombreanneeexpe }} an(s) d'expérience</div>
                    @endif
                  </div>
                </div>
              @else
                <p class="text-muted text-center">Aucune expérience renseignée.</p>
              @endif
            </div>
          </div>

          <!-- Emploi -->
          <div class="work-experience-section px-3 px-lg-4">
            <div class="row justify-content-center">
              <div class="col-md-8 text-center">
                <h2 class="h3 mb-4 font-weight-bold text-primary">Emploi</h2>
              </div>
            </div>

            <div class="timeline">
              <div class="timeline-card timeline-card-orange card shadow-sm mb-4">
                <div class="card-body">
                  @if(!empty($userdata->cv_summary))
                    <div class="mb-4">
                      <h6 class="text-uppercase font-weight-bold text-primary">Résumé du CV :</h6>
                      <p class="text-muted">{{ $userdata->cv_summary }}</p>
                    </div>
                  @endif

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="mb-2">
                        <div class="h6 font-weight-semibold">Premier secteur choisi :</div>
                        <div class="text-muted">{{ $userdata->emploi1->secteur->libelle ?? 'Non renseigné' }}</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-2">
                        <div class="h6 font-weight-semibold">Emploi concerné :</div>
                        <div class="text-muted">{{ $userdata->emploi1->libelle ?? 'Non renseigné' }}</div>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="mb-2">
                        <div class="h6 font-weight-semibold">Deuxième secteur choisi :</div>
                        <div class="text-muted">{{ $userdata->emploi2->secteur->libelle ?? 'Non renseigné' }}</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-2">
                        <div class="h6 font-weight-semibold">Emploi concerné :</div>
                        <div class="text-muted">{{ $userdata->emploi2->libelle ?? 'Non renseigné' }}</div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <footer class="pt-4 pb-4 text-muted text-center d-print-none"></footer>
    <script src="{{ asset('scripts/bootstrap.bundle.min.js?ver=1.2.0')}}"></script>
    <script src="{{ asset('scripts/aos.js?ver=1.2.0')}}"></script>
    <script src="{{ asset('scripts/main.js?ver=1.2.0')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
