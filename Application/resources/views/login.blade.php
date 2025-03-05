<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">
        <h2>Bienvenue</h2>
        <h3>Connexion</h3>
        <form id="loginForm" method="POST" action="{{ route('etudiant.login') }}">
            @csrf
            <label for="user_type">Type d'utilisateur:</label>
            <select id="user_type" name="user_type" onchange="toggleFields()" required>
                <option value="etudiant">Étudiant</option>
                <option value="bibliothecaire">Bibliothécaire</option>
            </select>

            <div id="etudiant_fields">
                <input type="email" name="email" placeholder="Email">
            </div>

            <div id="bibliothecaire_fields" style="display:none;">
                <input type="text" name="matricule" placeholder="Matricule">
            </div>

            <input type="password" name="password" placeholder="Mot de passe" required>
            <a href="#" style="color: #4CAF50;">Mot de passe oublié?</a>
            <button type="submit">Se connecter</button>
        </form>

        @if($errors->any())
            <div style="color: red;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="google-login">
            <p>ou</p>
            <a href="{{ route('auth.google') }}">
                <button class="google-button" type="button">Se connecter avec Google</button>
            </a>
        </div>
    </div>

    <script>
        function toggleFields() {
            const userType = document.getElementById('user_type').value;
            const etudiantFields = document.getElementById('etudiant_fields');
            const bibliothecaireFields = document.getElementById('bibliothecaire_fields');
            const form = document.getElementById('loginForm');

            if (userType === 'etudiant') {
                etudiantFields.style.display = 'block';
                bibliothecaireFields.style.display = 'none';
                form.action = "{{ route('etudiant.login') }}";
            } else {
                etudiantFields.style.display = 'none';
                bibliothecaireFields.style.display = 'block';
                form.action = "{{ route('bibliothecaire.login') }}";
            }
        }
    </script>
</body>
</html>
