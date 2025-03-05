<?php

use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\BibliothecaireController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\TravailController;
use Illuminate\Support\Facades\Route;


// Route de la page de connexion
Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    dd($request);
    if ($request->user_type === 'etudiant') {
        return app(EtudiantController::class)->login($request);
    } elseif ($request->user_type === 'bibliothecaire') {
        return app(BibliothecaireController::class)->login($request);
    }
    return back()->withErrors(['message' => 'Type d\'utilisateur non reconnu.']);
})->name('login.post');




// Routes pour l'authentification des étudiants
Route::post('/login/etudiant', [EtudiantController::class, 'login'])->name('etudiant.login');
Route::get('/etudiant/logout', [EtudiantController::class, 'logout'])->name('etudiant.logout');




// Middleware pour l'etudiant
Route::middleware('auth:etudiant')->group(function () {
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');

    Route::get('/travail/create', [TravailController::class, 'create'])->name('travail.create');  // Page de dépôt
    Route::get('/travail', [TravailController::class, 'index'])->name('travail.index');  // Page de consultation
});



//Routes pour le depot
Route::get('/etudiant/deposer', [TravailController::class, 'create'])->name('Etudiant.create');
Route::post('/etudiant/deposer', [TravailController::class, 'store'])->name('Etudiant.store');




//Route pour la consultation
Route::get('/etudiant/consulter/{filiere_id}', [TravailController::class, 'consulterParFiliere'])->name('travail.consulterParFiliere');
Route::get('/etudiant/choisir-filiere', [TravailController::class, 'choisirFiliere'])->name('travail.choisirFiliere');
Route::get('/etudiant/consulter', [TravailController::class, 'choisirFiliere'])->name('travail.choisirFiliere');
Route::get('/travail/{id}', [TravailController::class, 'show'])->name('travail.show');
Route::get('/travail/choisir-annee/{filiere_id}', [TravailController::class, 'choisirAnnee'])->name('travail.choisirAnnee');
Route::get('/travail/rechercher', [TravailController::class, 'rechercher'])->name('travail.rechercher');
Route::get('/travail/consulter/{id}', [TravailController::class, 'consulter'])->name('travail.consulter');




// Dépôt de TFC (interdit pour L1 et L2)
Route::middleware(['checkPromotion'])->group(function () {
    Route::get('/etudiant/deposer', [TravailController::class, 'create'])->name('Etudiant.create');
    Route::post('/etudiant/deposer', [TravailController::class, 'store'])->name('Etudiant.store');
});





Route::get('/tfc/view/{fichier}', function ($fichier) {
    $filePath = storage_path("app/public/$fichier");

    if (!file_exists($filePath)) {
        abort(404, "Fichier introuvable.");
    }

    return response()->file($filePath, [
        'Content-Disposition' => 'inline', // Affiche le fichier dans le navigateur
        'Content-Type' => 'application/pdf', // Spécifie que c'est un PDF
    ]);
})->name('tfc.view');



// Routes pour l'authentification des bibliothécaires
Route::post('/login/bibliothecaire', [BibliothecaireController::class, 'login'])->name('bibliothecaire.login');
// Routes pour la validation
Route::post('/travail/{travail}/valider', [TravailController::class, 'valider'])->name('travail.valider');
// Routes pour le rejet
Route::post('/travail/rejeter/{id}', [TravailController::class, 'rejeter'])->name('travail.rejeter');
// Routes pour supprimer les notifications
Route::delete('/etudiant/supprimer-notification/{id}', [EtudiantController::class, 'supprimerNotification']);

// Routes pour l'authentification Google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Middleware pour les bibliothécaires
Route::middleware(['auth:bibliothecaire'])->group(function () {
    Route::get('/etudiant/inscription', [EtudiantController::class, 'create'])->name('etudiant.create');
    Route::post('/etudiant', [EtudiantController::class, 'store'])->name('etudiant.store');
});

// Routes pour l'enregistrement du bibliothécaire
Route::get('/bibliothecaires/register', [BibliothecaireController::class, 'showRegisterForm'])->name('bibliothecaires.register');
Route::post('/bibliothecaires/register', [BibliothecaireController::class, 'register'])->name('bibliothecaires.register.submit');

// Routes pour la connexion du bibliothécaire
Route::get('/bibliothecaires/login', [BibliothecaireController::class, 'showLoginForm'])->name('bibliothecaires.login');
Route::post('/bibliothecaires/login', [BibliothecaireController::class, 'login'])->name('bibliothecaires.login.submit');

// Route pour afficher le tableau de bord du bibliothécaire
Route::middleware(['auth:bibliothecaire'])->group(function () {
    Route::get('/bibliothecaire/dashboard', [BibliothecaireController::class, 'dashboard'])->name('Bibliothecaire.page_bibliothecaire');
});

// Route pour la deconnexion du bibliothecaire
Route::get('/bibliothecaire/logout', [BibliothecaireController::class, 'logout'])->name('bibliothecaire.logout');

Route::middleware(['auth:bibliothecaire'])->group(function () {
    Route::get('/bibliothecaire/page', [BibliothecaireController::class, 'pageBibliothecaire'])->name('bibliothecaire.page');
});
//Routes pour la validation
Route::get('/travaux/approval', [TravailController::class, 'index'])->name('travaux.approval');



//Routes pour Filiere
Route::get('/filiere/create', [FiliereController::class, 'create'])->name('filiere.create');
Route::post('/filiere/store', [FiliereController::class, 'store'])->name('filiere.store');


