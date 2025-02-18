<!-- resources/views/admin/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Modifier les informations de l'utilisateur</h1>

    <form action="{{ route('admin.update', $utilisateur->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" value="{{ $utilisateur->firstname }}" required>
        </div>

        <div>
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" value="{{ $utilisateur->lastname }}" required>
        </div>

        <!-- Autres champs à éditer -->

        <button type="submit">Mettre à jour</button>
    </form>
@endsection
