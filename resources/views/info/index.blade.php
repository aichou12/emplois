<!-- resources/views/info/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Informations</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('info.create') }}" class="btn btn-primary mb-3">Ajouter une information</a>

    <!-- Table to display info -->
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Poste</th>
                <th>Numéro génére</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($infos as $info)
                <tr>
                    <td>{{ $info->id }}</td>
                    <td>{{ $info->nom }}</td>
                    <td>{{ $info->prenom }}</td>
                    <td>{{ $info->dernierposte }}</td>
                    <td>{{ $info->numero }}</td>
                    <td>
                        <a href="{{ route('info.edit', $info->id) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('info.destroy', $info->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
