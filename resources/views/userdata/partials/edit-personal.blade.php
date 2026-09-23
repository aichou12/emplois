<!-- Step 1: Personal Information -->
<div class="form-step" id="step-1">

  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
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
          timer: 3000,
          showConfirmButton: false
        });
      @endif

      @if($errors->any())
        Swal.fire({
          icon: 'error',
          title: 'Erreur de validation',
          html: `<ul style="text-align:left; font-size:14px; margin:0; padding-left:20px;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>`,
          confirmButtonColor: '#008C45'
        });
      @endif
    });
  </script>

  @if ($errors->any())
    <div class="alert alert-danger mb-4 shadow-sm" style="border-left: 4px solid var(--color-danger); background-color: #fff5f5; color: #1D1D1B; border-radius: var(--radius-sm);">
      <h6 class="fw-bold mb-2 text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Veuillez corriger les erreurs suivantes :</h6>
      <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 1 sur 4</div>
      <h2>Informations personnelles</h2>
      <p>Vérifiez vos informations d'identité et complétez votre situation personnelle.</p>
    </div>

    <div class="pgde-profile-panel">
      <div class="pgde-photo-ring">
        <img id="preview" src="{{ asset($userdata->photo_profil ? $userdata->photo_profil : 'images/images.png') }}" alt="Photo de profil" class="pgde-profile-photo">
      </div>
      <div class="pgde-profile-copy">
        <strong>Photo d'identité</strong>
        <span>Format carré recommandé (JPG, PNG).</span>
        <label for="photo_profil" class="pgde-upload-link">
          <i class="fas fa-camera"></i> Modifier la photo
        </label>
        <input type="file" id="photo_profil" name="photo_profil" accept="image/*" onchange="previewImage(event)" class="pgde-visually-hidden-input">
      </div>
    </div>

    <script>
      function previewImage(event) {
        if (event.target.files && event.target.files[0]) {
          const reader = new FileReader();
          reader.onload = function (e) {
            const preview = document.getElementById('preview');
            if (preview) preview.src = e.target.result;
          };
          reader.readAsDataURL(event.target.files[0]);
        }
      }
    </script>

    <div class="pgde-section-label">État civil & Identité</div>

    <div class="pgde-grid-2">
      <div class="form-group">
        <label for="edit-firstname"><i class="fas fa-user"></i> Nom</label>
        <input type="text" id="edit-firstname" class="form-control" value="{{ $userdata->utilisateur->firstname ?? 'Utilisateur inconnu' }}" readonly>
      </div>
      <div class="form-group">
        <label for="edit-lastname"><i class="fas fa-user"></i> Prénom</label>
        <input type="text" id="edit-lastname" class="form-control" value="{{ $userdata->utilisateur->lastname ?? 'Utilisateur inconnu' }}" readonly>
      </div>
    </div>

    <div class="pgde-grid-2">
      <div class="form-group">
        <label for="edit-numberid"><i class="fas fa-id-card"></i> CNI ou Passeport</label>
        <input type="text" id="edit-numberid" class="form-control" value="{{ $userdata->utilisateur->numberid ?? 'Utilisateur inconnu' }}" readonly>
      </div>
      <div class="form-group">
        <label for="genre"><i class="fas fa-venus-mars"></i> Genre</label>
        <select name="genre" id="genre" class="form-select">
          <option value="Masculin" {{ $userdata->genre == 'Masculin' ? 'selected' : '' }}>Homme</option>
          <option value="Feminin" {{ $userdata->genre == 'Feminin' ? 'selected' : '' }}>Femme</option>
        </select>
      </div>
    </div>

    <div class="pgde-section-label">Coordonnées & Naissance</div>

    <div class="pgde-grid-2">
      <div class="form-group">
        <label for="telephone1"><i class="fas fa-phone"></i> Téléphone 1</label>
        <input type="tel" class="form-control" id="telephone1" name="telephone1" value="{{ old('telephone1', $userdata->telephone1) }}" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
      </div>
      <div class="form-group">
        <label for="telephone2"><i class="fas fa-phone"></i> Téléphone 2</label>
        <input type="tel" class="form-control" id="telephone2" name="telephone2" value="{{ old('telephone2', $userdata->telephone2) }}" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
      </div>
    </div>

    <div class="pgde-grid-2">
      <div class="form-group">
        <label for="datenaiss"><i class="fas fa-calendar-alt"></i> Date de naissance</label>
        <input type="date" class="form-control" id="datenaiss" name="datenaiss" value="{{ $userdata->datenaiss }}">
      </div>
      <div class="form-group">
        <label for="lieunaiss"><i class="fas fa-map-marker-alt"></i> Lieu de naissance</label>
        <input type="text" class="form-control" id="lieunaiss" name="lieunaiss" value="{{ $userdata->lieunaiss }}">
      </div>
    </div>

    <div class="pgde-grid-2">
      <div class="form-group">
        <label for="regionnaiss_id"><i class="fas fa-globe-africa"></i> Région de naissance</label>
        <select name="regionnaiss_id" id="regionnaiss_id" class="form-select">
          @foreach($regions as $region)
            <option value="{{ $region->id }}" {{ $region->id == $userdata->regionnaiss_id ? 'selected' : '' }}>{{ $region->libelle }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="departementnaiss_id"><i class="fas fa-map-pin"></i> Département de naissance</label>
        <select name="departementnaiss_id" id="departementnaiss_id" class="form-select"></select>
      </div>
    </div>

    <div class="pgde-section-label">Situation matrimoniale & Résidence</div>

    <div class="pgde-grid-2">
      <div class="form-group">
        <label for="situationmatrimoniale"><i class="fas fa-heart"></i> Situation matrimoniale</label>
        <select name="situationmatrimoniale" id="situationmatrimoniale" class="form-select">
          <option value="Célibataire" {{ $userdata->situationmatrimoniale == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
          <option value="Marié(e)" {{ $userdata->situationmatrimoniale == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
          <option value="Divorcé(e)" {{ $userdata->situationmatrimoniale == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
          <option value="Veuf/Veuve" {{ $userdata->situationmatrimoniale == 'Veuf/Veuve' ? 'selected' : '' }}>Veuf/Veuve</option>
        </select>
      </div>
      <div class="form-group">
        <label for="nombreenfant"><i class="fas fa-child"></i> Nombre d'enfants</label>
        <input type="number" class="form-control" id="nombreenfant" name="nombreenfant" value="{{ old('nombreenfant', $userdata->nombreenfant) }}" min="0" max="30" oninput="if(this.value < 0) this.value = 0; if(this.value > 30) this.value = 30;">
      </div>
    </div>

    <div class="form-group">
      <label for="lieuresidence"><i class="fas fa-home"></i> Lieu de Résidence</label>
      <select class="form-control" id="lieuresidence" name="lieuresidence">
        <option value="Sénégal" {{ old('lieuresidence', $userdata->lieuresidence) == 'Sénégal' ? 'selected' : '' }}>Sénégal</option>
        <option value="Diaspora" {{ old('lieuresidence', $userdata->lieuresidence) == 'Diaspora' ? 'selected' : '' }}>Diaspora</option>
      </select>
    </div>

    <div class="pgde-grid-2">
      <div class="form-group" id="region-container">
        <label for="regionresidence_id"><i class="fas fa-map"></i> Région de Résidence</label>
        <select name="regionresidence_id" id="regionresidence_id" class="form-select">
          <option value="" disabled>-- Sélectionner une région --</option>
          @foreach($regions as $region)
            <option value="{{ $region->id }}" {{ $region->id == $userdata->regionresidence_id ? 'selected' : '' }}>{{ $region->libelle }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group" id="departement-container">
        <label for="departementresidence_id"><i class="fas fa-map-marked-alt"></i> Département de Résidence</label>
        <select name="departementresidence_id" id="departementresidence_id" class="form-select">
          <option value="" disabled selected>-- Sélectionner un département --</option>
          @foreach($departements as $departement)
            <option value="{{ $departement->id }}" {{ $departement->id == $userdata->departementresidence_id ? 'selected' : '' }}>{{ $departement->libelle }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="pgde-section-label">Situation particulière</div>

    <div class="form-group mt-3">
      <label class="mb-2"><i class="fas fa-wheelchair"></i> Souffrez-vous d'un handicap ?</label>
      <div class="pgde-radio-group">
        <label class="pgde-radio-option" for="handicap_no">
          <input type="radio" id="handicap_no" name="handicap" value="0" {{ empty($userdata->handicap_id) ? 'checked' : '' }} onclick="toggleHandicapField()">
          <span>Non</span>
        </label>
        <label class="pgde-radio-option" for="handicap_yes">
          <input type="radio" id="handicap_yes" name="handicap" value="1" {{ !empty($userdata->handicap_id) ? 'checked' : '' }} onclick="toggleHandicapField()">
          <span>Oui</span>
        </label>
      </div>
    </div>

    <div class="form-group mt-3" id="handicap_select" style="display: {{ !empty($userdata->handicap_id) ? 'block' : 'none' }};">
      <label for="handicap_id"><i class="fas fa-notes-medical"></i> Type de handicap :</label>
      <select name="handicap_id" id="handicap_id" class="form-select">
        <option value="">-- Choisir le handicap --</option>
        @foreach($handicap as $handicap_item)
          <option value="{{ $handicap_item->id }}" {{ (isset($userdata->handicap_id) && $userdata->handicap_id == $handicap_item->id) ? 'selected' : '' }}>{{ $handicap_item->libelle }}</option>
        @endforeach
      </select>
    </div>

    <div class="pgde-action-buttons">
      <div></div>
      <button type="button" class="next-step" id="suivant">
        <span>Suivant</span>
        <i class="fas fa-arrow-right"></i>
      </button>
    </div>
  </fieldset>
</div>
