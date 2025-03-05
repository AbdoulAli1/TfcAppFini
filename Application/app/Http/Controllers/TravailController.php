<?php

namespace App\Http\Controllers;

use App\Models\Travail;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Notifications\TravailRejeteNotification;
use Illuminate\Support\Facades\DB;

class TravailController extends Controller
{


    public function dashboard()
    {
        $travaux = Travail::with('etudiant.filiere')->get();
        return view('Etudiant.dashboard', compact('travaux'));
    }




    public function store(Request $request)
    {
        $etudiant = Auth::guard('etudiant')->user();

        // Bloquer le dépôt pour les étudiants de L1 et L2
        if (in_array($etudiant->promotion, ['L1', 'L2','L3'])) {
            return redirect()->route('travail.consulterParFiliere')
                ->with('error', 'Les étudiants de L1 L2 et L3 ne peuvent pas déposer un TFC.');
        }

        // Validation des champs
        $request->validate([
            'sujet' => 'required|string|max:255',
            'fichier' => 'required|mimes:pdf|max:10240', // max 10 MB
            'annee' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        if (!$etudiant) {
            return redirect()->route('etudiant.login')->withErrors(['message' => 'Vous devez être connecté pour déposer un TFC.']);
        }

        // Enregistrer le fichier
        $fichier = $request->file('fichier');
        $nomFichier = time() . '_' . $fichier->getClientOriginalName();
        $cheminFichier = $fichier->storeAs('tfc', $nomFichier, 'public');

        // Enregistrer les données du travail
        Travail::create([
            'sujet' => $request->input('sujet'),
            'fichier' => $cheminFichier,
            'date_depot' => now(),
            'etudiant_id' => $etudiant->id,
            'statut' => 'en attente',
            'annee' => $request->input('annee'),
        ]);

            return redirect()->route('travail.create')->with('success', 'Votre TFC a été déposé avec succès.');
    }



    //Deposer le travail
    public function create()
    {
            $etudiant = Auth::guard('etudiant')->user();

        // Bloquer l'accès pour les étudiants de L1 et L2
        if (in_array($etudiant->promotion, ['L1', 'L2','L3'])) {
            return redirect()->route('travail.choisirFiliere')
                ->with('error', 'Les étudiants de L1 L2 et L3 ne peuvent pas déposer un TFC.');
        }
            return view('Etudiant.create');
    }




    // Acceder a la page approprier pour consultation
    public function index()
    {
        if (Auth::guard('bibliothecaire')->check()) {
            $travaux = Travail::with('etudiant.filiere')->get();
            return view('Bibliothecaire.consulter', compact('travaux'));
        } elseif (Auth::guard('etudiant')->check()) {
            $travaux = Travail::with('etudiant.filiere')->where('statut', 'validé')->get();
            return view('Etudiant.consulter_etudiant', compact('travaux'));
        } else {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }
    }




    // Pour le bibliothecaire valider le tfc
    public function valider($travail_id)
    {
        $travail = Travail::findOrFail($travail_id);
        $travail->statut = 'validé';
        $travail->save();

        return redirect()->back()->with('success', 'TFC validé avec succès.');
    }




    // Pour le rejet du tfc
    public function rejeter(Request $request, $id)

    {

        // Récupérer le TFC concerné
        $travail = Travail::findOrFail($id);

        // Enregistrer le statut comme "rejeté" et le motif
        $travail->statut = 'rejeté';
        $travail->motif_rejet = $request->input('motif');
        $travail->save();

        // Notifier l'étudiant si nécessaire
        $etudiant = $travail->etudiant;
        if ($etudiant) {
            $notifications = $etudiant->notifications ? json_decode($etudiant->notifications, true) : [];
            $notifications[] = [
                'message' => "Votre TFC a été rejeté : ",
                'motif' => $travail->motif_rejet,
                'date' => now()->format('Y-m-d H:i:s'), // Format ISO 8601
            ];
            $etudiant->notifications = json_encode($notifications);
            $etudiant->save();
        }

        return back()->with('success', 'Le TFC a été rejeté avec succès.');
    }




    public function corrigerNotifications()
    {
        $etudiants = Etudiant::all();

        foreach ($etudiants as $etudiant) {
            if ($etudiant->notifications) {
                $notifications = json_decode($etudiant->notifications, true);
                foreach ($notifications as &$notification) {
                    if (isset($notification['date'])) {
                        try {
                            $notification['date'] = \Carbon\Carbon::parse($notification['date'])->format('Y-m-d H:i:s');
                        } catch (\Exception $e) {
                            // Si la date est invalide, on l'ignore ou on met une valeur par défaut
                            $notification['date'] = now()->format('Y-m-d H:i:s');
                        }
                    }
                }
                // Sauvegarde des notifications corrigées
                $etudiant->notifications = json_encode($notifications);
                $etudiant->save();
            }
        }

        return "Notifications corrigées avec succès !";
    }




    //Rechercher un TFC
    public function rechercher(Request $request)
    {
        $query = $request->input('query');

        // Cherche les TFC qui correspondent
        $travaux = Travail::where('sujet', 'LIKE', "%$query%")->get();

        // Si un seul résultat, on redirige directement vers sa page de lecture
        if ($travaux->count() === 1) {
            return redirect()->route('travail.show', ['id' => $travaux->first()->id]);
        }

        // Sinon, on affiche la liste des résultats
        return view('etudiant.dashboard', compact('travaux'));
    }





    //Choisir la filiere avant consultation
    public function choisirFiliere()
    {
        $filieres = Filiere::all();
        return view('Etudiant.choisir_filiere', compact('filieres'));
    }

    //choisir l'année avant consultation
    public function choisirAnnee($filiere_id)
    {
        $filiere = Filiere::findOrFail($filiere_id);
        $annees = Travail::whereHas('etudiant', function ($query) use ($filiere_id) {
            $query->where('filiere_id', $filiere_id);
        })->distinct()->pluck('annee');

        return view('Etudiant.choisir_annee', compact('filiere', 'annees'));
    }



    // Consultation
    public function consulterParFiliere(Request $request,$filiere_id)
    {

        // Récupérer uniquement les travaux validés pour l'étudiant
            $travaux = Travail::with('etudiant.filiere')
            ->where('statut', 'validé')
            ->whereHas('etudiant', function ($query) use ($filiere_id) {
            $query->where('filiere_id', $filiere_id);
        });

        if ($request->has('annee') && !empty($request->annee)) {
            $travaux->where('annee', $request->annee);
        }

        $travaux = $travaux->get();
        $filiere = Filiere::findOrFail($filiere_id);

        return view('Etudiant.consulter_etudiant', compact('travaux', 'filiere'));
    }

    public function consulter($id)
    {
        $tfc = Travail::findOrFail($id); // Récupérer le TFC sélectionné

        return view('Etudiant.consulter_tfc', compact('tfc'));
    }




    // Consulter un travail par filiere
    public function show($id)
    {
        $travail = Travail::with('etudiant.filiere')->findOrFail($id);
        return view('Etudiant.show', compact('travail'));
    }

}
