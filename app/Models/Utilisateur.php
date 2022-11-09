<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Utilisateur extends Model
{
    use HasFactory;
    use Sortable;

    protected $primaryKey = 'id_utilisateur';
    protected $table = 'utilisateur';
    protected $fillable = [
        'id_utilisateur',
        'Nom',
        'prenom',
        'genre',
        'url_utilisateur',
        'profil',
        'updated_at',
        'created_at'
    ];

    public $sortable = [ 'Nom', 'prenom','genre','id_utilisateur','url_utilisateur','profil'];

}
