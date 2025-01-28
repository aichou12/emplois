@extends('layouts.app')

@section('content')
<head>
<head>
    <!-- Ajouter le CDN Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

</head>
    <!-- Barre d'en-tête -->
    <header class="header-bar">
        <h2>Plateforme de demande d'emploi</h2>
    </header>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('info.store') }}" method="POST">
        @csrf

        <div>
            <label for="nom"><i class="fas fa-user"></i> Nom</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div>
            <label for="prenom"><i class="fas fa-user"></i> Prénom</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>

        <div>
            <label for="cni"><i class="fas fa-id-card"></i> CNI</label>
            <input type="text" id="cni" name="cni" required>
        </div>

        <div>
            <label for="genre"><i class="fas fa-venus-mars"></i> Genre</label>
            <select id="genre" name="genre" required>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select>
        </div>

        <div>
            <label for="datenaiss"><i class="fas fa-calendar-alt"></i> Date de naissance</label>
            <input type="date" id="datenaiss" name="datenaiss" required>
        </div>

        <div>
            <label for="lieu"><i class="fas fa-map-marker-alt"></i> Lieu de naissance</label>
            <input type="text" id="lieu" name="lieu" required>
        </div>

        <div>
            <label for="situation"><i class="fas fa-ring"></i> Situation matrimoniale</label>
            <select id="situation" name="situation" required>
                <option value="Célibataire">Célibataire</option>
                <option value="Marié(e)">Marié(e)</option>
                <option value="Divorcé(e)">Divorcé(e)</option>
                <option value="Veuf/Veuve">Veuf/Veuve</option>
            </select>
        </div>

        <div>
            <label for="nombrenfant"><i class="fas fa-child"></i> Nombre d'enfants</label>
            <input type="number" id="nombrenfant" name="nombrenfant" required>
        </div>

        <div>
            <label for="exp_professionnelle"><i class="fas fa-briefcase"></i> Expérience professionnelle</label>
            <textarea id="exp_professionnelle" name="exp_professionnelle" required></textarea>
        </div>

        <div>
            <label for="nombrexp"><i class="fas fa-cogs"></i> Nombre d'années d'expérience</label>
            <input type="number" id="nombrexp" name="nombrexp" required>
        </div>

        <div>
            <label for="dernierposte"><i class="fas fa-briefcase"></i> Dernier poste</label>
            <input type="text" id="dernierposte" name="dernierposte" required>
        </div>

        <div>
            <label for="dernieremp"><i class="fas fa-building"></i> Dernier employeur</label>
            <input type="text" id="dernieremp" name="dernieremp" required>
        </div>

        <div>
            <label for="cv"><i class="fas fa-file-alt"></i> CV</label>
            <textarea id="cv" name="cv" required></textarea>
        </div>

        <div>
            <label for="lettremoti"><i class="fas fa-file-alt"></i> Lettre de motivation</label>
            <textarea id="lettremoti" name="lettremoti" required></textarea>
        </div>

        <div>
            <label for="lieu_residence"><i class="fas fa-map-marker-alt"></i> Lieu de résidence</label>
            <select id="lieu_residence" name="lieu_residence" required>
                @foreach (\App\Models\Country::all() as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="adresse"><i class="fas fa-home"></i> Adresse</label>
            <input type="text" id="adresse" name="adresse" required>
        </div>

        <div>
            <label for="handicap"><i class="fas fa-wheelchair"></i> Handicap</label>
            <select name="handicap" id="handicap" required>
                <option value="0">Non</option>
                <option value="1">Oui</option>
            </select>
        </div>

        <div>
            <label for="diplome"><i class="fas fa-graduation-cap"></i> Diplôme</label>
            <input type="text" id="diplome" name="diplome" required>
        </div>

        <div>
            <label for="institution"><i class="fas fa-school"></i> Institution</label>
            <input type="text" id="institution" name="institution" required>
        </div>

        <div>
            <label for="intitule_diplome"><i class="fas fa-certificate"></i> Intitulé du diplôme</label>
            <input type="text" id="intitule_diplome" name="intitule_diplome" required>
        </div>

        <div>
            <label for="annee_obs"><i class="fas fa-calendar-check"></i> Année d'obtention</label>
            <input type="number" id="annee_obs" name="annee_obs" required>
        </div>

        <div>
            <label for="specialite"><i class="fas fa-cogs"></i> Spécialité</label>
            <input type="text" id="specialite" name="specialite" required>
        </div>

        <div>
            <label for="autre_diplome"><i class="fas fa-cogs"></i> Autre diplôme</label>
            <input type="text" id="autre_diplome" name="autre_diplome">
        </div>

        <!-- Secteur Dropdown -->
        <div>
            <label for="secteur_id"><i class="fas fa-briefcase"></i> Secteur</label>
            <select id="secteur_id" name="secteur_id" required onchange="fetchEmplois(this.value)">
                <option value="">-- Sélectionnez un secteur --</option>
                @foreach($secteurs as $secteur)
                    <option value="{{ $secteur->id }}">{{ $secteur->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Emploi Dropdown (Populated Dynamically) -->
        <div>
            <label for="nombre_annee_exp"><i class="fas fa-calendar-check"></i> Nombre d'années d'expérience</label>
            <input type="number" id="nombre_annee_exp" name="nombre_annee_exp" required>
        </div>

        <button type="submit">Soumettre</button>
    </form>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Style pour la barre d'en-tête */
        .header-bar {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .styled-form {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .styled-form div {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: inline-block;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Styles pour les icônes */
        label i {
            margin-right: 10px;
            color: #4CAF50;
            font-size: 18px;
        }
        label i {
    margin-right: 10px;
    color: #4CAF50; /* Change la couleur des icônes */
    font-size: 18px; /* Ajuste la taille des icônes */
}

    </style>
@endsection
