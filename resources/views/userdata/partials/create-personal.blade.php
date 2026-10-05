<!-- Étape 1 : informations personnelles -->
<div class="form-step" id="step-1">
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 1 sur 4</div>
      <h2>Informations personnelles</h2>
      {{-- <p>Vérifiez votre identité puis complétez vos coordonnées et votre situation.</p> --}}
    </div>

    <!-- Carte d'identité : photo + informations du compte, modifiables via le pop-up -->
    <div class="pgde-identity">
      <img id="preview" class="pgde-identity-photo" src="{{ asset('images/images.png') }}" alt="Photo de profil">
      <div class="pgde-identity-text">
        <strong id="identity-name">{{ trim(($utilisateurConnecte->firstname ?? '') . ' ' . ($utilisateurConnecte->lastname ?? '')) }}</strong>
        <ul class="pgde-identity-meta">
          <li><i class="fas fa-id-card" aria-hidden="true"></i> <span id="identity-numberid">{{ $utilisateurConnecte->numberid }}</span></li>
          <li><i class="fas fa-envelope" aria-hidden="true"></i> {{ $utilisateurConnecte->email }}</li>
        </ul>
        <span class="pgde-identity-hint" id="identity-photo-hint"><i class="fas fa-camera" aria-hidden="true"></i> Ajoutez une photo d'identité (facultatif)</span>
      </div>
      <button type="button" class="pgde-identity-edit" data-open-dialog="identity-dialog">
        <i class="fas fa-pen" aria-hidden="true"></i> <span>Modifier</span>
      </button>
    </div>

    <!-- Pop-up : photo, prénom, nom, CNI -->
    <dialog id="identity-dialog" class="pgde-dialog" aria-labelledby="identity-dialog-title">
      <div class="pgde-dialog-head">
        <h3 id="identity-dialog-title">Modifier mon identité</h3>
        <button type="button" class="pgde-dialog-close" data-close-dialog aria-label="Fermer"><i class="fas fa-xmark" aria-hidden="true"></i></button>
      </div>

      <!-- Photo : choix puis recadrage sur le visage -->
      <div class="pgde-dialog-photo" id="photo-picker">
        <img id="dialog-preview" src="{{ asset('images/images.png') }}" alt="Aperçu de la photo">
        <div>
          <label for="photo_profil" class="pgde-chip-button"><i class="fas fa-camera" aria-hidden="true"></i> Choisir une photo</label>
          <p class="pgde-dialog-help">Vous pourrez ensuite cadrer votre visage. JPG ou PNG.</p>
          {{-- Champ du formulaire : la photo recadrée est envoyée avec le dossier --}}
          <input type="file" id="photo_profil" name="photo_profil" accept="image/jpeg,image/png,image/gif" class="pgde-visually-hidden-input" onchange="openPhotoCropper(event)">
        </div>
      </div>

      <div class="pgde-cropper" id="photo-cropper" hidden>
        <p class="pgde-dialog-help"><i class="fas fa-up-down-left-right" aria-hidden="true"></i> Déplacez et zoomez pour centrer votre visage dans le cercle.</p>
        <div class="pgde-cropper-stage"><img id="crop-image" alt="Photo à recadrer"></div>
        <div class="pgde-cropper-tools">
          <button type="button" class="pgde-tool" data-crop="zoom-out" aria-label="Dézoomer"><i class="fas fa-magnifying-glass-minus" aria-hidden="true"></i></button>
          <button type="button" class="pgde-tool" data-crop="zoom-in" aria-label="Zoomer"><i class="fas fa-magnifying-glass-plus" aria-hidden="true"></i></button>
          <button type="button" class="pgde-tool" data-crop="rotate" aria-label="Pivoter"><i class="fas fa-rotate-right" aria-hidden="true"></i></button>
          <span class="pgde-tools-spacer"></span>
          <button type="button" class="pgde-btn pgde-btn-light" data-crop="cancel">Annuler</button>
          <button type="button" class="pgde-btn pgde-btn-primary" data-crop="apply"><i class="fas fa-check" aria-hidden="true"></i> Valider le cadrage</button>
        </div>
      </div>

      {{-- Champs sans attribut name : ils ne partent pas avec le dossier, ils sont enregistrés à part sur le compte --}}
      <div class="pgde-grid-2">
        <div class="form-group">
          <label for="account-firstname"><i class="fas fa-user"></i> Prénom</label>
          <input type="text" id="account-firstname" class="form-control" value="{{ $utilisateurConnecte->firstname }}" maxlength="255" autocomplete="given-name">
        </div>
        <div class="form-group">
          <label for="account-lastname"><i class="fas fa-user"></i> Nom</label>
          <input type="text" id="account-lastname" class="form-control" value="{{ $utilisateurConnecte->lastname }}" maxlength="255" autocomplete="family-name">
        </div>
      </div>
      <div class="form-group">
        <label for="account-numberid"><i class="fas fa-id-card"></i> N° CNI ou passeport</label>
        <input type="text" id="account-numberid" class="form-control" value="{{ $utilisateurConnecte->numberid }}" maxlength="255" autocapitalize="characters" oninput="this.value=this.value.replace(/[^A-Za-z0-9]/g,'')">
      </div>

      <p class="pgde-dialog-error" id="identity-dialog-error" role="alert" hidden></p>

      <div class="pgde-dialog-actions">
        <button type="button" class="pgde-btn pgde-btn-light" data-close-dialog>Annuler</button>
        <button type="button" class="pgde-btn pgde-btn-primary" id="identity-dialog-save" data-url="{{ route('account.identity.update') }}">
          <span>Enregistrer</span> <i class="fas fa-check" aria-hidden="true"></i>
        </button>
      </div>
    </dialog>

    <!-- ============ Bloc 1 : naissance et état civil ============ -->
    <section class="pgde-block" aria-labelledby="block-civil">
      <h3 id="block-civil" class="pgde-block-title">Naissance et état civil</h3>

      <div class="pgde-row">
        <div class="form-group c-3">
          <span class="pgde-group-label" id="label-genre">Genre <span class="pgde-req">*</span></span>
          <div class="pgde-seg" role="radiogroup" aria-labelledby="label-genre">
            <label class="pgde-seg-option"><input type="radio" name="genre" value="Masculin" required><span>Homme</span></label>
            <label class="pgde-seg-option"><input type="radio" name="genre" value="Feminin"><span>Femme</span></label>
          </div>
        </div>
        <div class="form-group c-3">
          <label for="datenaiss">Date de naissance <span class="pgde-req">*</span></label>
          {{-- Bornes alignées sur la règle serveur : de 18 à 59 ans --}}
          <input type="date" id="datenaiss" name="datenaiss" class="form-control" min="{{ now()->subYears(60)->addDay()->format('Y-m-d') }}" max="{{ now()->subYears(18)->format('Y-m-d') }}" required>
        </div>

        <div class="form-group c-2">
          <label for="lieunaiss">Lieu de naissance <span class="pgde-req">*</span></label>
          <input type="text" id="lieunaiss" name="lieunaiss" class="form-control" placeholder="Ville ou localité" maxlength="255" required>
        </div>
        <div class="form-group c-2">
          <label for="regionnaiss_id">Région <span class="pgde-req">*</span></label>
          <select name="regionnaiss_id" id="regionnaiss_id" class="form-select" required>
            <option value="" disabled selected>Choisir</option>
            @foreach($regions->sortBy(fn ($region) => \Illuminate\Support\Str::ascii(mb_strtolower(trim($region->libelle))) === 'hors senegal' ? 1 : 0) as $region)
              <option value="{{ $region->id }}">{{ $region->libelle }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group c-2">
          <label for="departementnaiss_id">Département <span class="pgde-req">*</span></label>
          <select name="departementnaiss_id" id="departementnaiss_id" class="form-select" required>
            <option value="" disabled selected>Après la région</option>
          </select>
        </div>

        <div class="form-group c-4">
          <span class="pgde-group-label" id="label-situation">Situation matrimoniale <span class="pgde-req">*</span></span>
          <div class="pgde-seg pgde-seg-4" role="radiogroup" aria-labelledby="label-situation">
            <label class="pgde-seg-option"><input type="radio" name="situationmatrimoniale" value="Célibataire" required><span>Célibataire</span></label>
            <label class="pgde-seg-option"><input type="radio" name="situationmatrimoniale" value="Marié(e)"><span>Marié(e)</span></label>
            <label class="pgde-seg-option"><input type="radio" name="situationmatrimoniale" value="Divorcé(e)"><span>Divorcé(e)</span></label>
            <label class="pgde-seg-option"><input type="radio" name="situationmatrimoniale" value="Veuf/Veuve"><span>Veuf / Veuve</span></label>
          </div>
        </div>
        <div class="form-group c-2">
          <label for="nombreenfant">Nombre d'enfants <span class="pgde-req">*</span></label>
          <div class="pgde-stepper">
            <button type="button" data-stepper="-1" aria-label="Retirer un enfant"><i class="fas fa-minus" aria-hidden="true"></i></button>
            <input type="number" id="nombreenfant" name="nombreenfant" value="0" min="0" max="30" inputmode="numeric" required>
            <button type="button" data-stepper="1" aria-label="Ajouter un enfant"><i class="fas fa-plus" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ Bloc 2 : contact et résidence ============ -->
    <section class="pgde-block" aria-labelledby="block-contact">
      <h3 id="block-contact" class="pgde-block-title">Contact et résidence</h3>

      <div class="pgde-row">
        <div class="form-group c-3">
          <label for="telephone1">Téléphone principal <span class="pgde-req">*</span></label>
          <input type="tel" name="telephone1" id="telephone1" placeholder="ex : 771234567" class="form-control" inputmode="numeric" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
        </div>
        <div class="form-group c-3">
          <label for="telephone2">Téléphone secondaire <span class="pgde-optional">facultatif</span></label>
          <input type="tel" name="telephone2" id="telephone2" placeholder="ex : 701234567" class="form-control" inputmode="numeric" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
        </div>

        <div class="form-group c-6">
          <span class="pgde-group-label" id="label-residence">Où résidez-vous ? <span class="pgde-req">*</span></span>
          <div class="pgde-seg pgde-seg-wide" role="radiogroup" aria-labelledby="label-residence">
            <label class="pgde-seg-option"><input type="radio" name="is_abroad" id="is_abroad" value="0" onchange="toggleFieldsAndUpdateResidence()" required><span><i class="fas fa-location-dot" aria-hidden="true"></i> Au Sénégal</span></label>
            <label class="pgde-seg-option"><input type="radio" name="is_abroad" id="is_abroad_1" value="1" onchange="toggleFieldsAndUpdateResidence()"><span><i class="fas fa-earth-africa" aria-hidden="true"></i> À l'étranger</span></label>
          </div>
          {{-- Valeur calculée automatiquement selon le choix ci-dessus --}}
          <input type="hidden" name="lieuresidence" id="lieuresidence">
        </div>

        <div class="form-group c-3 residence-senegal" id="region-container" hidden>
          <label for="regionresidence_id">Région de résidence <span class="pgde-req">*</span></label>
          <select name="regionresidence_id" id="regionresidence_id" class="form-select">
            <option value="" disabled selected>Choisir</option>
            @foreach($regions as $region)
              <option value="{{ $region->id }}">{{ $region->libelle }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group c-3 residence-senegal" id="departement-container" hidden>
          <label for="departementresidence_id">Département de résidence <span class="pgde-req">*</span></label>
          <select name="departementresidence_id" id="departementresidence_id" class="form-select">
            <option value="" disabled selected>Après la région</option>
          </select>
        </div>

        <div class="form-group c-3 residence-abroad" hidden>
          <label for="country_id">Pays de résidence <span class="pgde-req">*</span></label>
          <select name="country_id" id="country_id" class="form-select">
            <option value="" disabled selected>Choisir un pays</option>
            @foreach($countries as $country)
              <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group c-3 residence-abroad" hidden>
          <label for="addresse">Adresse <span class="pgde-req">*</span></label>
          <input type="text" name="addresse" id="addresse" class="form-control" placeholder="Ville, quartier, rue" maxlength="500">
        </div>
      </div>
    </section>

    <!-- ============ Handicap : une seule ligne ============ -->
    <section class="pgde-block pgde-block-inline" aria-labelledby="label-handicap">
      <div class="pgde-row">
        <div class="form-group c-3">
          <span class="pgde-group-label" id="label-handicap">Êtes-vous en situation de handicap ?</span>
          <div class="pgde-seg" role="radiogroup" aria-labelledby="label-handicap">
            <label class="pgde-seg-option"><input type="radio" id="handicap_no" name="handicap" value="0" checked onchange="toggleHandicapField()"><span>Non</span></label>
            <label class="pgde-seg-option"><input type="radio" id="handicap_yes" name="handicap" value="1" onchange="toggleHandicapField()"><span>Oui</span></label>
          </div>
        </div>
        <div class="form-group c-3" id="handicap_select" hidden>
          <label for="handicap_id">Type de handicap <span class="pgde-req">*</span></label>
          <select name="handicap_id" id="handicap_id" class="form-select">
            <option value="">Choisir le type</option>
            @foreach($handicaps as $handicap)
              <option value="{{ $handicap->id }}">{{ $handicap->libelle }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </section>

    <div class="pgde-action-buttons">
      <span></span>
      <button type="button" class="next-step" id="suivant">
        <span>Suivant</span> <i class="fas fa-arrow-right" aria-hidden="true"></i>
      </button>
    </div>
  </fieldset>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
  // ---------- Photo : recadrage carré centré sur le visage ----------
  let photoCropper = null;
  let photoBeforeCrop = null; // fichier choisi, remis si on annule

  function showPhotoPreview(dataUrl) {
    document.getElementById('preview').src = dataUrl;
    document.getElementById('dialog-preview').src = dataUrl;
    const hint = document.getElementById('identity-photo-hint');
    if (hint) hint.hidden = true;
  }

  function closePhotoCropper() {
    photoCropper?.destroy();
    photoCropper = null;
    document.getElementById('photo-cropper').hidden = true;
    document.getElementById('photo-picker').hidden = false;
  }

  function openPhotoCropper(event) {
    const input = event.target;
    const file = input.files && input.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) {
      alert('Choisissez une image (JPG ou PNG).');
      input.value = '';
      return;
    }
    photoBeforeCrop = file;
    const reader = new FileReader();
    reader.onload = e => {
      // Sans bibliothèque de recadrage (connexion coupée) : simple aperçu
      if (typeof Cropper === 'undefined') { showPhotoPreview(e.target.result); return; }
      const image = document.getElementById('crop-image');
      image.src = e.target.result;
      document.getElementById('photo-picker').hidden = true;
      document.getElementById('photo-cropper').hidden = false;
      photoCropper?.destroy();
      photoCropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 1,
        dragMode: 'move',
        autoCropArea: 0.8,
        background: false,
        guides: false,
        center: true,
        cropBoxResizable: true,
      });
    };
    reader.readAsDataURL(file);
  }

  document.addEventListener('click', event => {
    const action = event.target.closest('[data-crop]')?.dataset.crop;
    if (!action || !photoCropper) return;
    if (action === 'zoom-in') photoCropper.zoom(0.1);
    if (action === 'zoom-out') photoCropper.zoom(-0.1);
    if (action === 'rotate') photoCropper.rotate(90);
    if (action === 'cancel') {
      document.getElementById('photo_profil').value = '';
      closePhotoCropper();
    }
    if (action === 'apply') {
      // Image carrée 600 × 600 en JPEG : légère (< 2 Mo) et nette
      const canvas = photoCropper.getCroppedCanvas({ width: 600, height: 600, imageSmoothingQuality: 'high', fillColor: '#ffffff' });
      canvas.toBlob(blob => {
        if (!blob) return;
        const croppedFile = new File([blob], 'photo-profil.jpg', { type: 'image/jpeg' });
        const transfer = new DataTransfer();
        transfer.items.add(croppedFile);
        document.getElementById('photo_profil').files = transfer.files;
        showPhotoPreview(canvas.toDataURL('image/jpeg', 0.9));
        closePhotoCropper();
      }, 'image/jpeg', 0.9);
    }
  });

  // Résidence : Sénégal (région + département) ou diaspora (pays + adresse)
  function toggleFieldsAndUpdateResidence() {
    const choice = document.querySelector('input[name="is_abroad"]:checked')?.value;
    const isAbroad = choice === '1';
    const inSenegal = choice === '0';
    document.getElementById('lieuresidence').value = isAbroad ? 'Diaspora' : (inSenegal ? 'Sénégal' : '');
    document.querySelectorAll('.residence-senegal').forEach(field => { field.hidden = !inSenegal; });
    document.querySelectorAll('.residence-abroad').forEach(field => { field.hidden = !isAbroad; });
    document.getElementById('regionresidence_id').required = inSenegal;
    document.getElementById('departementresidence_id').required = inSenegal;
    document.getElementById('country_id').required = isAbroad;
    document.getElementById('addresse').required = isAbroad;
  }

  // Type de handicap : visible et obligatoire seulement si « Oui »
  function toggleHandicapField() {
    const hasHandicap = document.getElementById('handicap_yes').checked;
    document.getElementById('handicap_select').hidden = !hasHandicap;
    document.getElementById('handicap_id').required = hasHandicap;
  }

  // Nombre d'enfants : boutons − / + (entre 0 et 30)
  document.addEventListener('click', event => {
    const button = event.target.closest('[data-stepper]');
    if (!button) return;
    const input = button.parentElement.querySelector('input');
    const next = Math.min(Number(input.max), Math.max(Number(input.min), (Number(input.value) || 0) + Number(button.dataset.stepper)));
    input.value = next;
    input.dispatchEvent(new Event('input', { bubbles: true }));
    input.dispatchEvent(new Event('change', { bubbles: true }));
  });

  // Pop-up d'identité
  document.addEventListener('DOMContentLoaded', () => {
    const dialog = document.getElementById('identity-dialog');
    const errorBox = document.getElementById('identity-dialog-error');
    const saveButton = document.getElementById('identity-dialog-save');
    if (!dialog) return;

    document.querySelectorAll('[data-open-dialog="identity-dialog"]').forEach(button => button.addEventListener('click', () => {
      errorBox.hidden = true;
      dialog.showModal();
    }));
    dialog.querySelectorAll('[data-close-dialog]').forEach(button => button.addEventListener('click', () => dialog.close()));
    dialog.addEventListener('close', () => { if (photoCropper) closePhotoCropper(); });
    dialog.addEventListener('click', event => { if (event.target === dialog) dialog.close(); });

    saveButton.addEventListener('click', async () => {
      const payload = {
        firstname: document.getElementById('account-firstname').value.trim(),
        lastname: document.getElementById('account-lastname').value.trim(),
        numberid: document.getElementById('account-numberid').value.trim(),
      };
      errorBox.hidden = true;
      saveButton.disabled = true;
      try {
        const response = await fetch(saveButton.dataset.url, {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('#userdata-create-form [name="_token"]').value,
          },
          body: JSON.stringify(payload),
        });
        const result = await response.json();
        if (!response.ok) {
          throw new Error(Object.values(result.errors || {}).flat()[0] || result.message || 'L’enregistrement a échoué.');
        }
        document.getElementById('identity-name').textContent = `${result.firstname} ${result.lastname}`;
        document.getElementById('identity-numberid').textContent = result.numberid;
        dialog.close();
      } catch (error) {
        errorBox.textContent = error.message;
        errorBox.hidden = false;
      } finally {
        saveButton.disabled = false;
      }
    });
  });
</script>
