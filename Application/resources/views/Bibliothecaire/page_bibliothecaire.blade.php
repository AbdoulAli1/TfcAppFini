<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Bibliothécaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 30px;
            gap: 20px;
        }

        .card {
            width: 300px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        a {
            display: block;
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 10px;
        }

        a:hover {
            background-color: #45a049;
        }

        .logout-btn {
            background-color: #f44336;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h1>Tableau de Bord du Bibliothécaire</h1>
    <div class="container">
        <div class="card">
            <h2>Inscription des Étudiants</h2>
            <a href="{{ route('etudiant.create') }}">Accéder à l'inscription</a>
        </div>
        <div class="card">
            <h2>Gestion des Filières</h2>
            <a href="{{ route('filiere.create') }}">Gérer les Filières</a>
        </div>
        <div class="card">
            <h2>Approbation des Travaux</h2>
            <a href="{{ route('travaux.approval') }}">Voir les Travaux</a>
        </div>
    </div>

    <form action="{{ route('bibliothecaire.logout') }}" method="GET" style="text-align: center; margin-top: 20px;">
        @csrf
        <button type="submit" class="logout-btn">Déconnexion</button>
    </form>
</body>
</html>
