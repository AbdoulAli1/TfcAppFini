<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des TFC</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f9;
        }
    </style>
</head>
<body>
    <h1>TFC disponibles pour la Filière : {{ $filiere->intitule ?? 'Non spécifiée' }}</h1>

    @if($travaux->isEmpty())
        <p>Aucun TFC disponible pour le moment.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Sujet</th>
                    <th>Auteur</th> <!-- Nouvelle colonne -->
                    <th>Date de Dépôt</th>
                    <th>Statut</th>
                    <th>Fichier</th>
                    @if(Auth::guard('bibliothecaire')->check())
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($travaux as $travail)
                    <tr>
                        <td>{{ $travail->sujet }}</td>
                        <td>{{ $travail->etudiant->nom }} {{ $travail->etudiant->prenom }}</td>
                        <td>{{ $travail->date_depot }}</td>
                        <td>{{ $travail->statut }}</td>
                        <td>
                            <a href="{{ Storage::url($travail->fichier) }}" target="_blank">Lire le Travail</a>
                        </td>
                        @if(Auth::guard('bibliothecaire')->check())
                            <<td>
                                @if($travail->statut === 'en attente')
                                    <form action="{{ route('travail.valider', $travail->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit">Valider</button>
                                    </form>

                                    <!-- Formulaire de rejet -->
                                    <form action="{{ route('travail.rejeter', $travail->id) }}" method="POST" style="display:inline; margin-top: 5px;">
                                        @csrf
                                        <label for="motif">Motif du rejet :</label>
                                        <textarea name="motif" placeholder="Motif du rejet" required></textarea>
                                        <button type="submit" style="background-color: red; color: white;">Rejeter</button>
                                    </form>
                                @elseif($travail->statut === 'validé')
                                    <span style="color: green;">Validé</span>
                                @elseif($travail->statut === 'rejeté')
                                    <span style="color: red;">Rejeté</span>
                                    <br>
                                    <strong>Motif :</strong> {{ $travail->motif_rejet }}
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
