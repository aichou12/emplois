@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tableau de bord Admin</h1>
        <p>Bienvenue sur la page d'administration !</p>

        <h3>Liste des utilisateurs</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($utilisateurs as $utilisateur)
                    <tr>
                        <td>{{ $utilisateur->username }}</td>
                        <td>{{ $utilisateur->email }}</td>
                           <td>{{ $utilisateur->date_inscription }}</td>
                        <td>
                            <a href="{{ route('admin.edit', $utilisateur->id) }}" class="btn btn-primary">Modifier</a>
                            <form action="{{ route('admin.delete', $utilisateur->id) }}" method="POST" style="display:inline;">
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
