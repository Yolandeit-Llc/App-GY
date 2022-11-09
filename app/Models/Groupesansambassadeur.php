<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Groupesansambassadeur extends Model
{
    use HasFactory;
    use Sortable;
    protected $primaryKey = 'id_groupe';
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
        'nom_ambassadeur',
        'id_ambassadeur'  
    ];
    public $sortable = [ 'nom', 'type','nb_membres','statut_integration','tag_recherche', 'updated_at'];

}
