<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir une Filière</title>
    <link rel="stylesheet" href="{{ asset('css/choisir.css') }}">
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
