<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDBL Mémoire</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: #f3f4f6;
            color: #333;
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

        header {
            background: linear-gradient(90deg, #004080, #0066cc);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .user-info {
            position: absolute;
            top: 10px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info p {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
            color: #f0f0f0;
        }

        .logout-btn {
            background: #f44336;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #d32f2f;
        }

        /* Notifications section with full-width background */
        .notifications {
            margin: 20px auto;
            width: 100%; /* Prend toute la largeur */
            padding: 40px 20px;
            background-image: url('{{ asset('images/IMG_6238.JPG') }}'); /* Image de bibliothèque */
            background-size: cover; /* Adapte l'image pour couvrir tout l'espace */
            background-position: center; /* Centre l'image */
            background-repeat: no-repeat; /* Évite la répétition de l'image */
            border-radius: 12px;
            position: relative; /* superposer le contenu */
            color: white; /* Texte en blanc */
        }

        .notifications h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .notification-item {
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            margin-bottom: 15px;
            background: rgba(0, 0, 0, 0.6); /* Semi-transparence sur chaque notification */
            color: white; /* Texte blanc */
        }

        .notification-item p {
            margin: 0;
            font-size: 1rem;
            line-height: 1.5;
        }

        .notification-date {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #ddd;
        }

        .container {
            margin: 40px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px;
            padding: 0 20px;
        }

        .card {
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            text-align: center;
            padding: 30px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .card a {
            display: inline-block;
            background: #004080;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s;
        }

        .card a:hover {
            background: #0066cc;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #004080;
            color: white;
            margin-top: 40px;
        }

        .icon {
            font-size: 3rem;
            color: #004080;
            margin-bottom: 15px;
        }

        .icon:hover {
            color: #0066cc;
        }

        .empty-state {
            text-align: center;
            font-size: 1.1rem;
            color: #fff;
            margin: 20px auto;
            background: rgba(0, 0, 0, 0.6);
            padding: 10px 15px;
            border-radius: 8px;
            max-width: 400px;
        }

        .search-container {
            text-align: center;
            margin: 20px auto;
        }

        .search-container input {
            width: 60%;
            padding: 10px;
            border: 2px solid #004080;
            border-radius: 8px;
            font-size: 1rem;
            margin-right: 5px;
        }

        .search-container button {
            background: #004080;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }

        .search-container button:hover {
            background: #0066cc;
        }

    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <!-- Logo -->
        <img src="{{ asset('images/IMG_4172.jpg') }}" alt="Logo Université" class="logo">

        UDBL Mémoire
        <div class="user-info">
            <p>{{ $etudiant->nom }} {{ $etudiant->prenom }}</p>
            <form action="{{ route('etudiant.logout') }}" method="GET" style="margin: 0;">
                @csrf
                <button class="logout-btn" type="submit">Déconnexion</button>
            </form>
        </div>
        <!-- Barre de Recherche -->
        <div class="search-container">
            <form action="{{ route('travail.rechercher') }}" method="GET">
                <input type="text" name="query" placeholder="Rechercher un TFC..." required>
                <button type="submit">🔍 Rechercher</button>
            </form>
        </div>
    </header>

   <!-- Résultats de recherche -->
@if(isset($travaux) && count($travaux) > 0)
<div class="search-results">
    <h3>Résultats de recherche :</h3>
    <ul>
        @foreach($travaux as $travail)
            <li>
                <a href="{{ route('travail.show', ['id' => $travail->id]) }}">
                    {{ $travail->sujet }} - {{ $travail->etudiant->nom }} {{ $travail->etudiant->prenom }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endif



    <!-- Notifications -->
<div class="notifications">
    <h2>Vos Notifications</h2>
    @if(!empty($notifications))
        @foreach($notifications as $notification)
            @if(isset($notification['id'], $notification['message']))
                <div class="notification-item" id="notification-{{ $notification['id'] }}">
                    <p>{{ $notification['message'] }}</p>
                    @if(isset($notification['motif']) && !empty($notification['motif']))
                        <p><strong>Motif du rejet :</strong> {{ $notification['motif'] }}</p>
                    @endif
                    <p class="notification-date">
                        Reçu le :
                        @if(isset($notification['date']) && $notification['date'] !== 'Date invalide')
                            {{ $notification['date'] }}
                        @else
                            Date inconnue
                        @endif
                    </p>
                    <!-- Bouton de suppression -->
                    <button class="delete-notification" data-id="{{ $notification['id'] }}">🗑 Supprimer</button>
                </div>
            @endif
        @endforeach
    @else
        <p class="empty-state">Aucune notification disponible pour le moment.</p>
    @endif
</div>

 <!-- Options Section -->
 <div class="container">
    <div class="card">
        <div class="icon">📤</div>
        <h2>Déposer un TFC</h2>
        <a href="{{ route('travail.create') }}">Déposer un TFC</a>
    </div>
    <div class="card">
        <div class="icon">📚</div>
        <h2>Consulter les TFC</h2>
        <a href="{{ route('travail.choisirFiliere') }}">Consulter les TFC</a>
    </div>
</div>

<!-- Footer -->
<footer>
    &copy; {{ date('Y') }} Université Don Bosco de Lubumbashi. Tous droits réservés.
</footer>

<script>
    document.querySelectorAll('.delete-notification').forEach(button => {
        button.addEventListener('click', function () {
            let notificationId = this.getAttribute('data-id');

            fetch('/etudiant/supprimer-notification/' + notificationId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    document.getElementById('notification-' + notificationId).remove();
                }
            });
        });
    });
</script>


</body>
</html>
