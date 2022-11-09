<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Groupeavecsegmentation extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'groupeavecsegmentations';
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
        'tag_recherche',    
    ];

    public $sortable = [ 'nom', 'type','nb_membres','statut_integration','tag_recherche', 'updated_at'];

}
