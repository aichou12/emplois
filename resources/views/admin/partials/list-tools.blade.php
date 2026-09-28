<div class="row mb-3">
    <div class="col-md-6 d-flex align-items-start">
        <button class="btn btn-primary" type="button" id="exportExcel">
            <i class="fas fa-file-excel" aria-hidden="true"></i> Exporter en Excel
        </button>
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        <div class="dropdown d-inline-block">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-filter" aria-hidden="true"></i> Filtres
            </button>
            <div class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="filterDropdownBtn" id="filterMenu" style="min-width: 220px;">
                <label class="dropdown-item"><input type="checkbox" value="id"> Numéro FP</label>
                <label class="dropdown-item"><input type="checkbox" value="identity_number"> Numéro d’identité</label>
                <label class="dropdown-item"><input type="checkbox" value="username"> Nom d’utilisateur</label>
                <label class="dropdown-item"><input type="checkbox" value="email"> Adresse e-mail</label>
                <label class="dropdown-item"><input type="checkbox" value="firstname"> Prénom</label>
                <label class="dropdown-item"><input type="checkbox" value="lastname"> Nom</label>
                <label class="dropdown-item"><input type="checkbox" value="isActif"> Actif</label>
                <label class="dropdown-item"><input type="checkbox" value="isRecruted"> Recruté</label>
                <label class="dropdown-item"><input type="checkbox" value="dossier"> État du dossier</label>
                <label class="dropdown-item"><input type="checkbox" value="diplome"> Diplôme</label>
                <label class="dropdown-item"><input type="checkbox" value="genre"> Genre</label>
                <label class="dropdown-item"><input type="checkbox" value="annee_inscription"> Année d'inscription</label>
            </div>
        </div>
    </div>
</div>
