<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = ['contenu', 'travail_id', 'bibliothecaire_id'];

    public function travail()
    {
        return $this->belongsTo(Travail::class);
    }

    public function bibliothecaire()
    {
        return $this->belongsTo(Bibliothecaire::class);
    }

    public function reponses()
    {
        return $this->hasMany(ReponseCommentaire::class);
    }
}
