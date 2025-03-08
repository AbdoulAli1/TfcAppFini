<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des TFC</title>
    <link rel="stylesheet" href="{{ asset('css/consulter.css') }}">
</head>
<body>
    <header>Consultation des Travaux de Fin de Cycle (TFC)</header>

    <div class="container">
        <h1>TFC disponibles pour la Filière : {{ $filiere->intitule ?? 'Non spécifiée' }}</h1>

        @if($travaux->isEmpty())
            <p>Aucun TFC disponible pour le moment.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Sujet</th>
                        <th>Auteur</th>
                        <th>Date de Dépôt</th>
                        <th>Statut</th>
                        <th>Fichier</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($travaux as $travail)
                        <tr>
                            <td>{{ $travail->sujet }}</td>
                            <td>{{ $travail->etudiant->nom }} {{ $travail->etudiant->prenom }}</td>
                            <td>{{ $travail->date_depot }}</td>
                            <td>{{ $travail->statut }}</td>
                            <td>
                                <a href="{{ Storage::url($travail->fichier) }}" target="_blank">Lire le Travail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if(session('error'))
                <div class="error">
                    {{ session('error') }}
                </div>
            @endif
        @endif
    </div>
</body>
</html>
