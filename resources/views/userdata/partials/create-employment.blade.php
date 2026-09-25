     <!-- Step 4: Emploi -->
   <div class="form-step" id="step-4" style="display: none;">
   <fieldset>
          <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 4 sur 4</div>
      <h2>Projet professionnel & emplois ciblés</h2>
      <p>Précisez les emplois recherchés, votre profil et joignez votre CV.</p>
    </div>
       <div class="mb-3">
   <label for="cv_summary" ><i class="fas fa-file-alt" style="color:#00626D;" required></i>Résumé CV</label>
   <textarea id="cv_summary" placeholder="Résumé du CV (1000 caractères max)" name="cv_summary" class="form-control" rows="5" maxlength="1000"></textarea>
</div>



       <div class="form-group">
   <label for="cv_file"><i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre cv(8 mo max)</label>
   <input type="file" id="cv_file" name="cv_file[]" accept=".pdf,.doc,.docx,.rtf,.txt" class="form-control"  >
</div>



<!-- Sélection du secteur pour Emploi 1 -->
<div class="form-group mb-3">
   <label for="secteur1_id" style="display: block; margin-bottom: 5px;">
       <i class="fas fa-industry" style="color:#00626D;"></i>
   </label>
   <select name="secteur1_id" id="secteur1_id" class="form-control shadow-sm"required>
       <option value="" disabled selected>-- Choisissez le premier secteur dans lequel vous souhaitez travailler. --</option>
       @foreach($secteurs as $secteur)
           <option value="{{ $secteur->id }}">{{ $secteur->libelle }}</option>
       @endforeach
   </select>
</div>


<!-- Emploi 1 et nombre d'années d'expérience sur la même ligne -->
<div class="form-group d-flex gap-3">
   <div style="flex: 1;">
       <label for="emploi1_id" style="display: block; margin-bottom: 5px;">
           <i class="fas fa-briefcase" style="color:#00626D;"></i>
       </label>
       <select name="emploi1_id" id="emploi1_id" class="form-control shadow-sm" required>
           <option value="" disabled selected>-- Choisissez votre  emploi. --</option>
       </select>
   </div>
   <div style="flex: 1;">
       <label for="anneeexperience1" style="display: block; margin-bottom: 5px;">
           <i class="fas fa-building" style="color:#00626D;"></i>
       </label>
       <input type="number" id="anneeexperience1" name="anneeexperience1" placeholder="Nombre d'années d'expérience" class="form-control">
   </div>
</div>


<!-- Sélection du secteur pour Emploi 2 -->
<div class="form-group mb-3">
   <label for="secteur2_id" style="display: block; margin-bottom: 5px;">
       <i class="fas fa-industry" style="color:#00626D;"></i>
   </label>
   <select name="secteur2_id" id="secteur2_id" class="form-control shadow-sm" required>
       <option value="" disabled selected>-- Choisir le deuxième secteur dans lequel vous souhaitez travailler --</option>
       @foreach($secteurs as $secteur)
           <option value="{{ $secteur->id }}">{{ $secteur->libelle }}</option>
       @endforeach
   </select>
</div>


<!-- Emploi 2 et nombre d'années d'expérience sur la même ligne -->
<div class="form-group d-flex gap-3">
   <div style="flex: 1;">
       <label for="emploi2_id" style="display: block; margin-bottom: 5px;">
           <i class="fas fa-briefcase" style="color:#00626D;"></i>
       </label>
       <select name="emploi2_id" id="emploi2_id" class="form-control shadow-sm" required>
           <option value="" disabled selected>-- Choisir votre  emploi --</option>
       </select>
   </div>
   <div style="flex: 1;">
       <label for="anneeexperience2" style="display: block; margin-bottom: 5px;">
           <i class="fas fa-building" style="color:#00626D;"></i> Années d'expérience
       </label>
       <input type="number" id="anneeexperience2" name="anneeexperience2" placeholder="Nombre d'années d'expérience" class="form-control" >
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
   // Lorsqu'un secteur est sélectionné pour Emploi 1
   $('#secteur1_id').change(function () {
       let secteurId = $(this).val();
       let emploi1Select = $('#emploi1_id');
       emploi1Select.empty();
       emploi1Select.append('<option value="" disabled selected>Chargement...</option>');


       if (secteurId) {
           $.ajax({
               url: '/emplois-par-secteur/' + secteurId,
               type: 'GET',
               dataType: 'json',
               success: function (data) {
                   emploi1Select.empty();
                   if (data.length > 0) {
                       emploi1Select.append('<option value="" disabled selected>-- Choisir le premier emploi --</option>');
                       $.each(data, function (index, emploi) {
                           emploi1Select.append('<option value="' + emploi.id + '">' + emploi.libelle + '</option>');
                       });
                   } else {
                       emploi1Select.append('<option value="" disabled selected>Aucun emploi trouvé</option>');
                   }
               },
               error: function (xhr, status, error) {
                   console.error("Erreur AJAX pour Emploi 1:", error);
                   emploi1Select.empty();
                   emploi1Select.append('<option value="" disabled selected>Erreur de chargement</option>');
               }
           });
       } else {
           emploi1Select.html('<option value="" disabled selected>-- Choisir le premier emploi --</option>');
       }
   });


   // Lorsqu'un secteur est sélectionné pour Emploi 2
   $('#secteur2_id').change(function () {
       let secteurId = $(this).val();
       let emploi2Select = $('#emploi2_id');
       emploi2Select.empty();
       emploi2Select.append('<option value="" disabled selected>Chargement...</option>');


       if (secteurId) {
           $.ajax({
               url: '/emplois-par-secteur/' + secteurId,
               type: 'GET',
               dataType: 'json',
               success: function (data) {
                   emploi2Select.empty();
                   if (data.length > 0) {
                       emploi2Select.append('<option value="" disabled selected>-- Choisir le deuxième emploi --</option>');
                       $.each(data, function (index, emploi) {
                           emploi2Select.append('<option value="' + emploi.id + '">' + emploi.libelle + '</option>');
                       });
                   } else {
                       emploi2Select.append('<option value="" disabled selected>Aucun emploi trouvé</option>');
                   }
               },
               error: function (xhr, status, error) {
                   console.error("Erreur AJAX pour Emploi 2:", error);
                   emploi2Select.empty();
                   emploi2Select.append('<option value="" disabled selected>Erreur de chargement</option>');
               }
           });
       } else {
           emploi2Select.html('<option value="" disabled selected>-- Choisir le deuxième emploi --</option>');
       }
   });
 });
</script>



<!-- SECTEUR 1 -->








       <div class="pgde-action-buttons">

    <!-- Bouton Précédent -->
    <button type="button" style="background-color:gray;" id="prev" class="prev-step">
        <i class="fa fa-arrow-left"></i> Précédent
    </button>

    <!-- Bouton Soumettre -->
    <div class="pgde-submit-area">
        <button type="submit" class="btn-submit-step" aria-disabled="true">Soumettre</button>
    </div>









</div>
 </fieldset>
    </div>


