<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des TFC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #004080;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 1.5em;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        h1 {
            color: #333;
            font-size: 1.8em;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f9;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        td a {
            color: #004080;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }
    </style>
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
