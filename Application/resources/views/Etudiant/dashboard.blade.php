<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDBL Mémoire</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
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
