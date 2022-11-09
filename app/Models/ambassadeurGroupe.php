<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class ambassadeurGroupe extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'ambassadeur_groupe';
    protected $fillable = [
        'id_ambassadeur',
        'statut_adhesion',
        'id_groupe',
        'date_adhesion',
        'notifications',
        'traitement',
        'statut_releve',
        'releve_100_posts',
        'nb_posts_releves_analyse'
     ];
     public $sortable = ['id_ambassadeur', 'statut_adhesion', 'id_groupe', 'date_adhesion', 'notifications', 'statut_releve','releve_100_posts', 'nb_posts_releves_analyse'];
}
