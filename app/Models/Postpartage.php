<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Postpartage extends Model
{
    use HasFactory;
    use Sortable;

    protected $primaryKey = 'id_post';
    protected $fillable = [
        'id_post',
        'id_groupe',
        'nom',
        'prenom',
        'message_personnalise',
        'statut',
        'id_utilisateur'

    ];
    public $sortable = [ 'id_post','nom', 'message_personnalise','prenom','statut','id_utilisateur'];

}
