<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement Bibliothécaire</title>
    <link rel="stylesheet" href="{{ asset('css/bibliothecaireregister.css') }}">

</head>
<body>
    <form action="{{ route('bibliothecaires.register.submit') }}" method="POST">
        @csrf
        <h1>Enregistrement</h1>
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>

        <label for="matricule">Matricule</label>
        <input type="text" id="matricule" name="matricule" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit">S'enregistrer</button>
        <div class="link">
            <a href="{{ route('login') }}">Déjà enregistré ? Connectez-vous</a>
        </div>
    </form>
</body>
</html>
