<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Étudiant</title>
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <script>
        function handlePromotionChange() {
            const promotion = document.getElementById('promotion').value;
            const filiereSelect = document.getElementById('filiere_id');
            const filiereHidden = document.getElementById('hidden_filiere_id');
            const isL1L2 = (promotion === 'L1' || promotion === 'L2');

            // Activer/désactiver le champ "filière"
            filiereSelect.disabled = isL1L2;

            // Si L1 ou L2, on met à jour la valeur du champ caché
            if (isL1L2) {
                filiereSelect.value = ""; // Reset l'affichage du select
                filiereHidden.value = ""; // Champ caché
            } else {
                filiereHidden.value = filiereSelect.value; // Synchro avec le select visible
            }
        }

        function syncFiliere() {
            const filiereSelect = document.getElementById('filiere_id');
            const filiereHidden = document.getElementById('hidden_filiere_id');
            filiereHidden.value = filiereSelect.value;
        }
    </script>
</head>
<body>

    <h1>Inscription d'un Étudiant</h1>

    <!-- Affichage des erreurs de validation -->
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('etudiant.store') }}" method="POST">
        @csrf

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required>

        <label for="postNom">Post-nom</label>
        <input type="text" name="postnom" id="postNom" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required placeholder="exemple@esisalama.org ou exemple@esisalamasi.org">
        <small>Seules les adresses des domaines esisalama.org et esisalamasi.org sont autorisées.</small>

        <label for="password">Mot de passe</label>
        <input type="password" name="mot_de_passe" id="password" required>

        <label for="password_confirmation">Confirmez le mot de passe</label>
        <input type="password" name="mot_de_passe_confirmation" id="password_confirmation" required>

        <label for="promotion">Promotion</label>
        <select name="promotion" id="promotion" required onchange="handlePromotionChange()">
            <option value="">-- Sélectionnez une promotion --</option>
            <option value="L1">L1</option>
            <option value="L2">L2</option>
            <option value="L3">L3</option>
            <option value="L4">L4</option>
        </select>

        <label for="filiere_id">Filière</label>
        <select name="visible_filiere_id" id="filiere_id" disabled onchange="syncFiliere()">
            <option value="">-- Sélectionnez une filière --</option>
            @foreach ($filieres as $filiere)
                <option value="{{ $filiere->id }}">{{ $filiere->intitule }}</option>
            @endforeach
        </select>

        <!-- Champ caché pour "filiere_id" -->
        <input type="hidden" name="filiere_id" id="hidden_filiere_id" value="">

        <button type="submit">S'inscrire</button>
    </form>

</body>
</html>
