<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function create()
    {
        return view('filiere.create'); // Correspond à la vue que vous avez fournie
    }

    public function store(Request $request)
    {
        $request->validate([
            'intitule' => 'required|string|max:255|unique:filieres',
        ]);

        Filiere::create([
            'intitule' => $request->input('intitule'),
        ]);

        return redirect()->route('filiere.create')->with('success', 'Filière ajoutée avec succès.');
    }
}
