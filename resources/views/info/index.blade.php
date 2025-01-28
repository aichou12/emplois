<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Informations</title>
</head>
<body>
    <h1>Liste des Informations</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>CNI</th>
                <th>Genre</th>
                <th>Date de naissance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($infos as $info)
                <tr>
                    <td>{{ $info->nom }}</td>
                    <td>{{ $info->prenom }}</td>
                    <td>{{ $info->cni }}</td>
                    <td>{{ $info->genre }}</td>
                    <td>{{ $info->datenaiss }}</td>
                    <td>
                        <!-- Vous pouvez ajouter des actions comme modifier, supprimer, etc. -->
                        <a href="#">Modifier</a> | 
                        <a href="#">Supprimer</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><a href="{{ route('info.create') }}">Ajouter une nouvelle information</a></p>
</body>
</html>
