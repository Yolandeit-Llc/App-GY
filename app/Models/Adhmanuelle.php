<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adhmanuelle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_groupe',
        'nom',
        'personnalisation',
        'nb_membres',
        'theme',
        'type',
        'reglementation',
        'url_a_propos',
        'frequence_post_mois',
        'format_groupe',
        'lieu',
        'actif_supprime',
        'statut_releve',
        'date_releve',
        'statut_integration',
        'tag_recherche'    ];
}

