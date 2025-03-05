<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Bibliothecaire;

class BibliothecaireController extends Controller
{
    public function login(Request $request)
    {


        $credentials = $request->only('matricule', 'password');

        $bibliothecaire = Bibliothecaire::where('matricule', $credentials['matricule'])->first();

        if ($bibliothecaire && Hash::check($credentials['password'], $bibliothecaire->mot_de_passe)) {
            Auth::guard('bibliothecaire')->login($bibliothecaire);
            //dd('Connexion réussie pour ' . $bibliothecaire->matricule);  // Débogage
            return redirect()->route('bibliothecaire.page');
        }

        return back()->withErrors(['message' => 'Identifiants incorrects pour le bibliothécaire.']);
    }

    public function pageBibliothecaire()
    {
        return view('Bibliothecaire.page_bibliothecaire');
    }

    public function showRegisterForm()
    {
        return view('Bibliothecaire/bibliothecaire_register');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        // Validation des données d'entrée
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'matricule' => 'required|string|unique:bibliothecaires',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Création du bibliothécaire avec le mot de passe haché
        Bibliothecaire::create([
            'nom' => $validatedData['nom'],
            'matricule' => $validatedData['matricule'],
            'mot_de_passe' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('bibliothecaires.login')->with('success', 'Bibliothécaire enregistré avec succès.');
    }

    public function logout()
    {
        Auth::guard('bibliothecaire')->logout();
        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }

}
