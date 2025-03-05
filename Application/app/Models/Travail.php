<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travail extends Model
{
    use HasFactory;

    protected $table = 'travaux';
    protected $fillable = ['sujet', 'fichier', 'date_depot', 'statut', 'date_validation', 'etudiant_id', 'bibliothecaire_id', 'motif_rejet', 'annee'];


    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function bibliothecaire()
    {
        return $this->belongsTo(Bibliothecaire::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
}
