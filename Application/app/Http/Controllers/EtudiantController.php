<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Travail;

class EtudiantController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Récupérer l'étudiant avec l'email fourni
        $etudiant = Etudiant::where('email', $credentials['email'])->first();

        // Vérifier le mot de passe avec Hash::check et le champ 'mot_de_passe'
        if ($etudiant && Hash::check($credentials['password'], $etudiant->mot_de_passe)) {
            Auth::guard('etudiant')->login($etudiant);
            //dd(Auth::guard('etudiant')->user());
            return redirect()->intended('/etudiant/dashboard');
        }

        return back()->withErrors(['message' => 'Identifiants incorrects pour l\'étudiant.']);
    }

    public function create()
    {

        $filieres = Filiere::all();
        return view('Bibliothecaire.inscription_etudiant', compact('filieres'));
        return view('Bibliothecaire/inscription_etudiant');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'postnom' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:etudiants,email',
                'regex:/^[a-zA-Z0-9._%+-]+@(esisalama\.org|esisalamasi\.org)$/'
        ],
            'promotion' => 'required|string',
            'filiere_id' => 'nullable|exists:filieres,id', // "nullable" pour L1 et L2
            'mot_de_passe' => 'required|string|min:6|confirmed',
        ]);

        // Vérification pour L1 et L2
        if (in_array($validatedData['promotion'], ['L1', 'L2'])) {
        $validatedData['filiere_id'] = null; // Aucun filière pour L1 et L2
        }

        // Création de l'étudiant
        Etudiant::create([
            'nom' => $validatedData['nom'],
            'postnom'=>$validatedData['postnom'],
            'email' => $validatedData['email'],
            'filiere_id' => $validatedData['filiere_id'],
            'promotion' => $validatedData['promotion'],
            'mot_de_passe' => Hash::make($validatedData['mot_de_passe']),
        ]);

        return redirect()->route('etudiant.create')->with('success', 'Étudiant enregistré avec succès.');
    }


    public function dashboard()
    {
        $etudiant = Auth::guard('etudiant')->user();
        $notifications = $etudiant->notifications ? json_decode($etudiant->notifications, true) : [];

        foreach ($notifications as &$notification) {
            if (!isset($notification['id'])) {
                $notification['id'] = uniqid(); // Générer un ID unique si absent
            }
        }

        // Sauvegarder les notifications avec un ID unique
        $etudiant->notifications = json_encode($notifications);
        $etudiant->save();

        return view('Etudiant.dashboard', compact('etudiant', 'notifications'));
    }


    public function supprimerNotification($id)
    {
        $etudiant = Auth::guard('etudiant')->user();
        $notifications = $etudiant->notifications ? json_decode($etudiant->notifications, true) : [];

        // Filtrer pour garder seulement les notifications qui n'ont pas cet ID
        $notifications = array_filter($notifications, function ($notification) use ($id) {
            return $notification['id'] !== $id;
        });

        // Sauvegarder les notifications mises à jour
        $etudiant->notifications = json_encode(array_values($notifications));
        $etudiant->save();

        return response()->json(['message' => 'Notification supprimée avec succès']);
    }



    public function logout()
    {
        // Déconnexion de l'étudiant
        Auth::guard('etudiant')->logout();

        // Redirection vers la page de connexion
        return redirect()->route('login')->with('message', 'Deconnexion reussi.');
    }

}
