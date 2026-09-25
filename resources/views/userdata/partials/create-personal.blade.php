    <!-- Step 1: Personal Information -->
    <div class="form-step" id="step-1">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<fieldset>
  <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 1 sur 4</div>
      <h2>Informations personnelles</h2>
      <p>Complétez votre identité, vos coordonnées et votre situation personnelle.</p>
    </div>


<div class="pgde-section-label">État civil & identité</div>

      <div class="pgde-profile-panel">
        <div class="pgde-photo-ring"><img id="preview" src="{{ asset('images/images.png') }}" alt="Photo de profil" class="pgde-profile-photo"></div>
        <div class="pgde-profile-copy">
          <strong>Photo de profil</strong>
          <span>Format carré recommandé (JPG, PNG).</span>
          <label for="photo_profil" class="pgde-upload-link"><i class="fas fa-camera"></i> Ajouter une photo</label>
          <input type="file" id="photo_profil" name="photo_profil" accept="image/*" capture="environment" class="pgde-visually-hidden-input" onchange="previewImage(event)">
        </div>
      </div>


      <div class="form-group flex">
        <div class="flex-1 pr-2">
            <label for="utilisateur_id"><i class="fas fa-user" style="color:#00626D;"></i>Prénom</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->firstname }} "
         readonly>  </div>

        <div class="flex-1 pl-2">
            <label for="utilisateur_id"><i class="fas fa-user"style="color:#00626D;"></i>Nom</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->lastname }} "
         readonly>  </div>
      </div>

      <div class="form-group flex">
        <div class="flex-1 pr-2">
            <label for="utilisateur_id"><i class="fas fa-id-card"style="color:#00626D;"></i>Cni ou Passport</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->numberid }} "
         readonly> </div>
        <div class="flex-1 pl-2">
            <label for="genre"><i class="fas fa-venus-mars"style="color:#00626D;"></i>Genre <span class="text-red-500 ml-1">*</span></label>
            <select id="genre" name="genre" required>
            <option value="" disabled selected>-- Choisir le sexe --</option>
            <option value="Masculin">Homme</option>
            <option value="Feminin">Femme</option>
        </select>

                </div>
            </div>
            <div class="pgde-section-label">Coordonnées & naissance</div>
            <div class="form-group flex">
            <div class="flex-1 pr-2">
                <label for="telephone1"><i class="fas fa-phone"style="color:#00626D;"></i>Téléphone 1 <span class="text-red-500 ml-1">*</span></label>
                <input type="text" name="telephone1" id="telephone1" placeholder = "Téléphone 1" class="form-control shadow-sm" type="tel" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                </div>
            <div class="flex-1 pl-2">
                <label for="telephone2"><i class="fas fa-phone"style="color:#00626D;"></i>Téléphone 2</label>
                <input type="text" name="telephone2" id="telephone2" placeholder = "Téléphone 2" class="form-control shadow-sm" type="tel" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')">

                    </div>
        </div>
        <div class="form-group flex">
            <div class="flex-1 pr-2">
                <label for="datenaiss"><i class="fas fa-calendar-alt"style="color:#00626D;"></i>Date de naissance <span class="text-red-500 ml-1">*</span></label>
                <input type="date" id="datenaiss" name="datenaiss" min="1966-01-01" max="{{ now()->format('Y-m-d') }}" required>
                <small class="form-text text-muted">La date doit être comprise entre le 1er janvier 1966 et aujourd’hui.</small>
            </div>
            <div class="flex-1 pl-2">
                <label for="lieunaiss"><i class="fas fa-map-marker-alt"style="color:#00626D;"></i>Lieu de naissance <span class="text-red-500 ml-1">*</span></label>

                <input type="text" id="lieunaiss" name="lieunaiss" placeholder = "Lieu de naissance"required>
            </div>
        </div>
        <div class="form-group flex">
        <div class="flex-1 pr-2">
       <label for="regionnaiss_id"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Région de Naissance <span class="text-red-500 ml-1">*</span></label>
       <select name="regionnaiss_id" id="regionnaiss_id" class="form-control" required>
           <option value="" disabled selected>-- Région de Naissance --</option>
           @foreach($regions->sortBy(fn ($region) => \Illuminate\Support\Str::ascii(mb_strtolower(trim($region->libelle))) === 'hors senegal' ? 1 : 0) as $region)
               <option value="{{ $region->id }}">{{ $region->libelle }}</option>
           @endforeach
       </select>
   </div>


   <div class="flex-1 pl-2">
       <label for="departementnaiss_id"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Départememnt de naissance <span class="text-red-500 ml-1">*</span></label>
       <select name="departementnaiss_id" id="departementnaiss_id" class="form-control" required>
           <option value="" disabled selected>-- Département de Naissance --</option>
       </select>
   </div>
</div>



<div class="pgde-section-label">Situation matrimoniale & résidence</div>
<div class="form-group flex">
       <div class="flex-1 pr-2">
           <label for="situationmatrimoniale"><i class="fa-solid fa-users" style="color:#00626D;"></i>
           Situation matrimoniale<span class="text-red-500 ml-1">*</span>
           </label>
           <select id="situationmatrimoniale" name="situationmatrimoniale" required>
           <option value="" disabled selected>-- Situation matrimoniale --</option>
               <option value="Célibataire">Célibataire</option>
               <option value="Marié(e)">Marié(e)</option>
               <option value="Divorcé(e)">Divorcé(e)</option>
               <option value="Veuf/Veuve">Veuf/Veuve</option>
           </select>

        </div>

        <div class="flex-1 pl-2">
            <label for="nombreenfant"><i class="fas fa-child"style="color:#00626D;"></i>Nombre d'enfants
            <span class="text-red-500 ml-1">*</span></label>
            <input type="number" id="nombreenfant" name="nombreenfant" placeholder = "Nombre d'enfants" min="0" max="30" oninput="if(this.value < 0) this.value = 0; if(this.value > 30) this.value = 30;" required>
        </div>
</div>
            <div class="form-group">
            <div class="form-group flex">
       <div class="flex-1 pr-2">
       <label for="situationmatrimoniale"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Où résidez-vous ?</label>
        <select name="is_abroad" id="is_abroad" class="form-control" onchange="toggleFieldsAndUpdateResidence()" required>
            <option value="" disabled selected>--Chosissez votre lieu de résidence --</option>
            <option value="0">Sénégal</option>
            <option value="1">Diaspora</option>
        </select>

        </div>

        <div class="flex-1 pl-2">

            <label for="lieuresidence"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Lieu de Résidence<span class="text-red-500 ml-1">*</span></label>

       <input type="text" name="lieuresidence" id="lieuresidence" placeholder = "Lieu de Résidence"class="form-control shadow-sm" readonly required>
          </div>
</div>




<div class="form-group flex">
    <!-- Région de Résidence -->
    <div class="flex-1 pr-2" id="region-container">
        <label for="regionresidence_id">Région de Résidence<span class="text-red-500 ml-1">*</span></label>
        <select name="regionresidence_id" id="regionresidence_id" class="form-control">
            <option value="" disabled selected>-- Région de Résidence --</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}">{{ $region->libelle }}</option>
            @endforeach
        </select>
    </div>

    <!-- Département de Résidence -->
    <div class="flex-1 pr-2" id="departement-container">
        <label for="departementresidence_id">Département de Résidence<span class="text-red-500 ml-1">*</span></label>
        <select name="departementresidence_id" id="departementresidence_id" class="form-control">
            <option value="" disabled selected>-- Département de Résidence --</option>
        </select>
    </div>
</div>

<!-- Champs pour la Diaspora -->
<div class="form-group flex" id="diaspora-fields" style="display: none;">
    <div class="flex-1 pr-2">
        <label for="country_id">Pays de Résidence<span class="text-red-500 ml-1">*</span></label>
        <select name="country_id" id="country_id" class="form-control" >
            <option value="" disabled selected>-- Sélectionnez le pays --</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>  <!-- Assurez-vous que 'name' et 'id' sont les bons attributs -->
            @endforeach
        </select>
    </div>

    <div class="flex-1 pr-2">
        <label for="addresse">Adresse<span class="text-red-500 ml-1">*</span></label>
        <input type="text" name="addresse" id="addresse" class="form-control" >
    </div>
</div>


<script>
    function previewImage(event) {
        if (!event.target.files || !event.target.files[0]) return;
        const reader = new FileReader();
        reader.onload = function (e) { document.getElementById("preview").src = e.target.result; };
        reader.readAsDataURL(event.target.files[0]);
    }
    function toggleFieldsAndUpdateResidence() {
        const isAbroad = document.getElementById('is_abroad').value;
        const regionField = document.getElementById('region-container');
        const departementField = document.getElementById('departement-container');
        const lieuResidenceField = document.getElementById('lieuresidence');
        const diasporaFields = document.getElementById('diaspora-fields');
        const residenceRegion = document.getElementById('regionresidence_id');
        const residenceDepartment = document.getElementById('departementresidence_id');
        const country = document.getElementById('country_id');
        const address = document.getElementById('addresse');

        // Mise à jour de la valeur du lieu de résidence et masquage des champs en fonction de la sélection
        if (isAbroad === '1') {
            // Lieu de résidence = "Diaspora" si hors du pays
            lieuResidenceField.value = "Diaspora";
            regionField.style.display = 'none';
            departementField.style.display = 'none';
            diasporaFields.style.display = 'flex';  // Afficher les champs pour le pays et l'adresse
            residenceRegion.required = false;
            residenceDepartment.required = false;
            country.required = true;
            address.required = true;
        } else {
            // Lieu de résidence = "Sénégal" si dans le pays
            lieuResidenceField.value = "Sénégal";
            regionField.style.display = 'block';
            departementField.style.display = 'block';
            diasporaFields.style.display = 'none';  // Masquer les champs pour le pays et l'adresse
            residenceRegion.required = true;
            residenceDepartment.required = true;
            country.required = false;
            address.required = false;
        }
    }

    // Initialement cacher les champs région, département, et ceux pour la diaspora
    window.onload = function() {
        document.getElementById('region-container').style.display = 'none';
        document.getElementById('departement-container').style.display = 'none';
        document.getElementById('diaspora-fields').style.display = 'none';
    }
</script>



<!-- Sélection des régions -->









    </div>




 <div class="pgde-section-label">Situation particulière</div>
 <!-- Champ handicap supplémentaire qui s'affiche uniquement si "Oui" est sélectionné -->
 <div class="form-group" style="display: flex; align-items: center; gap: 20px;">
    <label for="handicap" style="margin-right: 10px;">
        <i class="fas fa-wheelchair" style="color:#00626D;"></i> Souffrez-vous d'un handicap ?
    </label>
    <div style="display: flex; gap: 20px;">
        <label for="handicap_no" style="display: flex; align-items: center; gap: 8px;">
            <input type="radio" id="handicap_no" name="handicap" value="0" checked onclick="toggleHandicapField()">
            <span>Non</span>
        </label>
        <label for="handicap_yes" style="display: flex; align-items: center; gap: 8px;">
            <input type="radio" id="handicap_yes" name="handicap" value="1" onclick="toggleHandicapField()">
            <span>Oui</span>
        </label>
    </div>
</div>

<!-- Sélecteur de handicap (caché par défaut) -->
<div class="form-group mt-2" id="handicap_select" style="display: none;">
    <label for="handicap_id" class="fw-bold" style="color: #00626D;">Type de handicap :</label>
    <select name="handicap_id" id="handicap_id" class="form-control shadow-sm border-primary">
        <option value="">Choisir le handicap</option>
        @foreach($handicaps as $handicap)
            <option value="{{ $handicap->id }}">{{ $handicap->libelle }}</option>
        @endforeach
    </select>
</div>

<script>
    function toggleHandicapField() {
        let handicapSelect = document.getElementById('handicap_select');
        let handicapYes = document.getElementById('handicap_yes');

        if (handicapYes.checked) {
            handicapSelect.style.display = 'block'; // Afficher le select
        } else {
            handicapSelect.style.display = 'none'; // Cacher le select
        }
    }
</script>
<div class="pgde-action-buttons">






       <button type="button" class="next-step flex items-center" id = "suivant">
           <span>Suivant</span>
           <i class="fas fa-arrow-right ml-2"></i> <!-- Arrow icon (left) -->
       </button>


   </div>
   </div>

     <!-- form fields -->


     </fieldset>









