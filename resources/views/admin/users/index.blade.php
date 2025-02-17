<!-- resources/views/admin/users/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des utilisateurs</h1>

        <!-- Table des utilisateurs -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Rôle</th>
                </tr>
            </thead>
            <tbody>
                @foreach($utilisateurs as $utilisateur)
                    <tr>
                        <td>{{ $utilisateur->username }}</td>
                        <td>{{ $utilisateur->firstname }} {{ $utilisateur->lastname }}</td>
                        <td>{{ $utilisateur->email }}</td>
                        <td>{{ implode(', ', json_decode($utilisateur->roles, true)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
