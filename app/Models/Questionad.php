<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionad extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_question',
        'nom',
        'theme',
        'nb_membres',
        'id_groupe',
        'question',
        'reponse',
        'reponse2',
        'reponse3',    
    ];
}
