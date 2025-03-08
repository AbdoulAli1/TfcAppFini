<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déposer un TFC</title>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body>
    <!-- Logo -->
    <img src="{{ asset('images/IMG_4172.jpg') }}" alt="Logo Université" class="logo">

    <div class="container">
        <h1>Déposer un TFC</h1>
        <form action="{{ route('Etudiant.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="sujet">Sujet</label>
                <input type="text" name="sujet" id="sujet" required placeholder="Entrez le sujet de votre TFC">
            </div>
            <div>
                <label for="annee">Année</label>
                <input type="number" name="annee" id="annee" required min="2000" max="{{ date('Y') }}" placeholder="Entrez l'année">
            </div>
            <div>
                <label for="fichier">Fichier (PDF, max 10MB)</label>
                <input type="file" name="fichier" id="fichier" accept=".pdf" required>
            </div>
            <button type="submit">Valider</button>
        </form>

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
