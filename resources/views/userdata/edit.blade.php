@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Modifier Userdata</h1>

    <form action="{{ route('userdata.update', $userdata->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Utilisateur -->
            <div class="col-md-6 mb-3">
                <label for="utilisateur_id" class="form-label">Utilisateur</label>
                <select name="utilisateur_id" id="utilisateur_id" class="form-select">
                    @foreach($utilisateurs as $utilisateur)
                        <option value="{{ $utilisateur->id }}" {{ $utilisateur->id == $userdata->utilisateur_id ? 'selected' : '' }}>
                            {{ $utilisateur->firstname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Département de naissance -->
            <div class="col-md-6 mb-3">
                <label for="departementnaiss_id" class="form-label">Département de Naissance</label>
                <select name="departementnaiss_id" id="departementnaiss_id" class="form-select">
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}" {{ $departement->id == $userdata->departementnaiss_id ? 'selected' : '' }}>
                            {{ $departement->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Département de résidence -->
            <div class="col-md-6 mb-3">
                <label for="departementresidence_id" class="form-label">Département de Résidence</label>
                <select name="departementresidence_id" id="departementresidence_id" class="form-select">
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}" {{ $departement->id == $userdata->departementresidence_id ? 'selected' : '' }}>
                            {{ $departement->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Emploi 1 -->
            <div class="col-md-6 mb-3">
                <label for="emploi1_id" class="form-label">Emploi 1</label>
                <select name="emploi1_id" id="emploi1_id" class="form-select">
                    @foreach($emplois as $emploi)
                        <option value="{{ $emploi->id }}" {{ $emploi->id == $userdata->emploi1_id ? 'selected' : '' }}>
                            {{ $emploi->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Autres champs à remplir de la même manière -->

        <!-- Soumettre le formulaire -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
