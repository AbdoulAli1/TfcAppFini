<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir une Année</title>
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
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        select {
            padding: 10px;
            font-size: 1em;
            margin-bottom: 15px;
            width: 80%;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            padding: 10px 15px;
            font-size: 1em;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #003366;
        }
    </style>
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
