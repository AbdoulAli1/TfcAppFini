<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir une Année</title>
    <link rel="stylesheet" href="{{ asset('css/annee.css') }}">
</head>
<body>

<div class="container">
    <h1>Choisissez une Année</h1>

    <form action="{{ route('travail.consulterParFiliere', $filiere->id) }}" method="GET">
        <select name="annee" required>
            <option value="">Sélectionnez une année</option>
            @foreach($annees as $annee)
                <option value="{{ $annee }}">{{ $annee }}</option>
            @endforeach
        </select>
        <button type="submit">Voir les Travaux</button>
    </form>
</div>

</body>
</html>
