<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Campagne extends Model
{

    public $sortable = [ 'nom','etat', 'score','date_debut','date_fin','contexte'];
    use HasFactory;
    use Sortable;

    protected $primaryKey = 'id_campagne';
    protected $fillable = [
        'id_campagne',
        'nom',
        'score',
        'date_debut',
        'date_fin',
        'contexte',
        'contenu_post_mere',
        'objectifs',
        'recommandation',
        'bilan',
        'date_programmation',
        'etat',
        'nb_likes',
        'nb_comments',
        'nb_shares',
        'portee',
        'id_segmentation',
    ];




}
