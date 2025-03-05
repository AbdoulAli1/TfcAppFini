<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReponseCommentaire extends Model
{
    use HasFactory;

    protected $fillable = ['contenu', 'commentaire_id', 'etudiant_id'];

    public function commentaire()
    {
        return $this->belongsTo(Commentaire::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
