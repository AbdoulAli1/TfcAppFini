<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir une Filière</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative; /* Permet de positionner des éléments absolus */
        }

        .profile-picture {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 50px;
            height: 50px;
            border-radius: 50%; /* Forme ronde */
            border: 2px solid #fff; /* Optionnel, ajoute une bordure blanche */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optionnel, ajoute une ombre douce */
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.8em;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        li:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        a {
            display: block;
            padding: 15px;
            text-decoration: none;
            font-size: 1em;
            font-weight: bold;
            text-align: center;
            color: #004080;
            border-radius: 8px;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }

        a:hover {
            background-color: #004080;
            color: #fff;
        }

        p {
            font-size: 1em;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Ajout de l'image dans le coin supérieur gauche -->
    <img src="{{ asset('images/IMG_4172.jpg') }}" alt="Logo Université" class="profile-picture">

    <div class="container">
        <h1>Choisissez une Filière</h1>
        @if($filieres->isEmpty())
            <p>Aucune filière disponible pour le moment.</p>
        @else
            <ul>
                @foreach($filieres as $filiere)
                    <li>
                        <a href="{{ route('travail.choisirAnnee', $filiere->id) }}">
                            {{ $filiere->intitule }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
