<!-- Step 1: Personal Information -->
<div class="form-step" id="step-1">

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
    <div class="alert alert-danger mb-4 shadow-sm" style="border-left: 4px solid #ED2939;">
      <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i> Veuillez corriger les erreurs suivantes :</h6>
      <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <fieldset>
    <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
      <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">
        Étape 1 : Informations personnelles
      </h3>
    </legend>

    <div class="mb-3">
      <img id="preview" src="{{ asset($userdata->photo_profil ? $userdata->photo_profil : 'images/images.png') }}" alt="Photo de profil" width="150" height="150" class="rounded shadow-sm" style="object-fit: cover; max-height: 150px;">
    </div>

    <label for="photo_profil"><i class="fas fa-camera"></i> Changer la photo</label>
    <input type="file" id="photo_profil" name="photo_profil" accept="image/*" onchange="previewImage(event)">

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

    <div class="form-group flex">
      <div class="flex-1 pr-2">
        <label for="edit-firstname"><i class="fas fa-user" style="color:#00626D;"></i>Nom</label>
        <input type="text" id="edit-firstname" class="form-control" value="{{ $userdata->utilisateur->firstname ?? 'Utilisateur inconnu' }}" readonly>
      </div>
      <div class="flex-1 pl-2">
        <label for="edit-lastname"><i class="fas fa-user" style="color:#00626D;"></i>Prénom</label>
        <input type="text" id="edit-lastname" class="form-control" value="{{ $userdata->utilisateur->lastname ?? 'Utilisateur inconnu' }}" readonly>
      </div>
    </div>

    <div class="form-group flex">
      <div class="flex-1 pr-2">
        <label for="edit-numberid"><i class="fas fa-id-card" style="color:#00626D;"></i>CNI ou Passport</label>
        <input type="text" id="edit-numberid" class="form-control" value="{{ $userdata->utilisateur->numberid ?? 'Utilisateur inconnu' }}" readonly>
      </div>
      <div class="flex-1 pl-2">
        <label for="genre"><i class="fas fa-venus-mars" style="color:#00626D;"></i>Genre</label>
        <select name="genre" id="genre" class="form-select">
          <option value="Masculin" {{ $userdata->genre == 'Masculin' ? 'selected' : '' }}>Homme</option>
          <option value="Feminin" {{ $userdata->genre == 'Feminin' ? 'selected' : '' }}>Femme</option>
        </select>
      </div>
    </div>

    <div class="form-group flex">
      <div class="flex-1 pr-2">
        <label for="telephone1"><i class="fas fa-phone" style="color:#00626D;"></i>Téléphone 1</label>
        <input type="text" class="form-control" id="telephone1" name="telephone1" value="{{ old('telephone1', $userdata->telephone1) }}" type="tel" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
      </div>
      <div class="flex-1 pl-2">
        <label for="telephone2"><i class="fas fa-phone" style="color:#00626D;"></i>Téléphone 2</label>
        <input type="text" class="form-control" id="telephone2" name="telephone2" value="{{ old('telephone2', $userdata->telephone2) }}" type="tel" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
      </div>
    </div>

    <div class="form-group flex">
      <div class="flex-1 pr-2">
        <label for="datenaiss"><i class="fas fa-calendar-alt" style="color:#00626D;"></i>Date de naissance</label>
        <input type="date" class="form-control" id="datenaiss" name="datenaiss" value="{{ $userdata->datenaiss }}">
      </div>
      <div class="flex-1 pl-2">
        <label for="lieunaiss"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Lieu de naissance</label>
        <input type="text" class="form-control" id="lieunaiss" name="lieunaiss" value="{{ $userdata->lieunaiss }}">
      </div>
    </div>

    <div class="form-group flex">
      <div class="flex-1 pr-2">
        <label for="regionnaiss_id"><i class="fas fa-calendar-alt" style="color:#00626D;"></i>Région de naissance</label>
        <select name="regionnaiss_id" id="regionnaiss_id" class="form-select">
          @foreach($regions as $region)
            <option value="{{ $region->id }}" {{ $region->id == $userdata->regionnaiss_id ? 'selected' : '' }}>{{ $region->libelle }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex-1 pl-2">
        <label for="departementnaiss_id"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Département de naissance</label>
        <select name="departementnaiss_id" id="departementnaiss_id" class="form-select"></select>
      </div>
    </div>

    <div class="form-group flex">
      <div class="flex-1 pr-2">
        <label for="situationmatrimoniale"><i class="fa-solid fa-users" style="color:#00626D;"></i>Situation matrimoniale</label>
        <select name="situationmatrimoniale" id="situationmatrimoniale" class="form-select">
          <option value="Célibataire" {{ $userdata->situationmatrimoniale == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
          <option value="Marié(e)" {{ $userdata->situationmatrimoniale == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
          <option value="Divorcé(e)" {{ $userdata->situationmatrimoniale == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
          <option value="Veuf/Veuve" {{ $userdata->situationmatrimoniale == 'Veuf/Veuve' ? 'selected' : '' }}>Veuf/Veuve</option>
        </select>
      </div>
      <div class="flex-1 pl-2">
        <label for="nombreenfant"><i class="fas fa-child" style="color:#00626D;"></i>Nombre d'enfants</label>
        <input type="number" class="form-control" id="nombreenfant" name="nombreenfant" value="{{ old('nombreenfant', $userdata->nombreenfant) }}" min="0" max="30" oninput="if(this.value < 0) this.value = 0; if(this.value > 30) this.value = 30;">
      </div>
    </div>

    <div class="form-group">
      <label for="lieuresidence">Lieu de Résidence</label>
      <select class="form-control" id="lieuresidence" name="lieuresidence">
        <option value="Sénégal" {{ old('lieuresidence', $userdata->lieuresidence) == 'Sénégal' ? 'selected' : '' }}>Sénégal</option>
        <option value="Diaspora" {{ old('lieuresidence', $userdata->lieuresidence) == 'Diaspora' ? 'selected' : '' }}>Diaspora</option>
      </select>
    </div>

    <div class="form-group flex">
      <div class="flex-1 pr-2" id="region-container">
        <label for="regionresidence_id">Région de Résidence</label>
        <select name="regionresidence_id" id="regionresidence_id" class="form-select">
          <option value="" disabled>-- Sélectionner une région --</option>
          @foreach($regions as $region)
            <option value="{{ $region->id }}" {{ $region->id == $userdata->regionresidence_id ? 'selected' : '' }}>{{ $region->libelle }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex-1 pl-2" id="departement-container">
        <label for="departementresidence_id">Département de Résidence</label>
        <select name="departementresidence_id" id="departementresidence_id" class="form-control">
          <option value="" disabled selected>-- Sélectionner un département --</option>
          @foreach($departements as $departement)
            <option value="{{ $departement->id }}" {{ $departement->id == $userdata->departementresidence_id ? 'selected' : '' }}>{{ $departement->libelle }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group" style="display: flex; align-items: center; gap: 20px;">
      <label for="handicap" style="margin-right: 10px;"><i class="fas fa-wheelchair" style="color:#00626D;"></i> Souffrez-vous d'un handicap ?</label>
      <div style="display: flex; gap: 20px;">
        <label for="handicap_no" style="display: flex; align-items: center; gap: 8px;"><input type="radio" id="handicap_no" name="handicap" value="0" {{ empty($userdata->handicap_id) ? 'checked' : '' }} onclick="toggleHandicapField()"><span>Non</span></label>
        <label for="handicap_yes" style="display: flex; align-items: center; gap: 8px;"><input type="radio" id="handicap_yes" name="handicap" value="1" {{ !empty($userdata->handicap_id) ? 'checked' : '' }} onclick="toggleHandicapField()"><span>Oui</span></label>
      </div>
    </div>

    <div class="form-group mt-2" id="handicap_select" style="display: {{ !empty($userdata->handicap_id) ? 'block' : 'none' }};">
      <label for="handicap_id" class="fw-bold" style="color: #00626D;">Type de handicap :</label>
      <select name="handicap_id" id="handicap_id" class="form-control shadow-sm border-primary">
        <option value="">Choisir le handicap</option>
        @foreach($handicap as $handicap)
          <option value="{{ $handicap->id }}" {{ (isset($userdata->handicap_id) && $userdata->handicap_id == $handicap->id) ? 'selected' : '' }}>{{ $handicap->libelle }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group flex justify-start mt-4">
      <button type="button" class="next-step flex items-center" id="suivant">
        <span>Suivant</span>
        <i class="fas fa-arrow-right ml-2"></i>
      </button>
    </div>
  </fieldset>
</div>
