<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déposer un TFC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

            /* Logo Style */
            .logo {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        button {
            padding: 12px;
            background-color: #004080;
            color: white;
            font-size: 1em;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #003366;
        }

        .error-messages {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }

        .error-messages ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .error-messages li {
            margin-bottom: 8px;
        }
    </style>
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
