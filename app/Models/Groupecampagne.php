<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupecampagne extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_campagne';
    protected $table = 'campagne_groupe';
    protected $fillable = [
        'id_campagne','id_groupe ', 'statut_publication','statut_recherche','traitement_publication','updated_at','created_at'
    ];
}
