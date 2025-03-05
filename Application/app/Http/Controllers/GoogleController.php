<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Vérifie si l'utilisateur existe déjà
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Si l'utilisateur existe, connecte-le
                Auth::login($user);
            } else {
                // Sinon, crée un nouvel utilisateur
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(str_random(24)), // Mot de passe placeholder
                ]);

                Auth::login($user);
            }

            return redirect()->intended('/dashboard'); // Redirige vers le tableau de bord
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Impossible de vous connecter avec Google.');
        }
    }
}
