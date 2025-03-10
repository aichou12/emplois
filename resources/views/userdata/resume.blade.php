@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Détails de l'Agent</h2>

        <div class="row">
            <!-- Informations Personnelles -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Informations Personnelles</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>CNI/Passport:</strong> {{ $utilisateur->numberid }}</p>
                        <p><strong>Username:</strong> {{ $utilisateur->username }}</p>
                        <p><strong>Email:</strong> {{ $utilisateur->email }}</p>
                        <p><strong>Nom Complet:</strong> {{ $utilisateur->firstname }} {{ $utilisateur->lastname }}</p>
                        <p><strong>Activation:</strong> {{ $utilisateur->enabled ? 'Activé' : 'Désactivé' }}</p>
                        <p><strong>Recruté:</strong> {{ $utilisateur->recruted ? 'Oui' : 'Non' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informations Complémentaires -->
            @if($utilisateur->userdata)
                <div class="col-md-6">
                    <div class="card mt-4 mt-md-0">
                        <div class="card-header">
                            <h5>Informations Complémentaires</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Date de Naissance:</strong> {{ $utilisateur->userdata->datenaiss }}</p>
                            <p><strong>Lieu de Naissance:</strong> {{ $utilisateur->userdata->lieunaiss }}</p>
                            <p><strong>Situation Matrimoniale:</strong> {{ $utilisateur->userdata->situationmatrimoniale }}</p>
                            <p><strong>Numéro de Téléphone:</strong> {{ $utilisateur->userdata->telephone1 }}</p>
                            <p><strong>Nombre d'Enfants:</strong> {{ $utilisateur->userdata->nombreenfant }}</p>
                            <p><strong>Spécialité:</strong> {{ $utilisateur->userdata->specialite }}</p>
                            <p><strong>Diplôme:</strong> {{ $utilisateur->userdata->diplome }}</p>
                            <p><strong>Expériences Professionnelles:</strong> {{ $utilisateur->userdata->experiences }}</p>
                            <p><strong>Employeur:</strong> {{ $utilisateur->userdata->employeur }}</p>
                            <p><strong>Adresse:</strong> {{ $utilisateur->userdata->addresse }}</p>

                            <p><strong>Diplômes Supplémentaires:</strong> 
                                @foreach($utilisateur->userdata->academics as $academic)
                                    <span>{{ $academic->diplome }} ({{ $academic->pivot->anneediplome }} - {{ $academic->pivot->etablissementdiplome }}),</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-4 col-md-6">
                    Aucune information complémentaire disponible.
                </div>
            @endif
        </div>

        <a href="{{ route('admin.users') }}" class="btn btn-secondary mt-4">Retour à la liste des utilisateurs</a>
    </div>
@endsection
