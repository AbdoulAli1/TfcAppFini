<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Etudiant extends Authenticatable
{

    use Notifiable;

    use HasFactory;

    protected $fillable = ['nom', 'postnom', 'email', 'mot_de_passe', 'filiere_id', 'promotion','notifications'];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }


    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function travaux()
    {
        return $this->hasMany(Travail::class);
    }
}
