<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambassadeur extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ambassadeur';
    protected $fillable = [
        'id_ambassadeur',
        'login',
        'mdp',
        'authentification_facebook',
        'cookies'

    ];
    public $sortable = [ 'id_ambassadeur', 'login','mdp','authentification_facebook',
    'url_utilisateur','updated_at','created_at'];

}
