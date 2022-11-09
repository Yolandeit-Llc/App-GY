<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postgroupe extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_post';
    protected $fillable = [
        'id_post',
        'id_campagne',
        'url_post',
        'statut_scrappe',
        'titre',
        'type_media',
        'legende',
        'hashtag',
        'portee',
        'interaction',  
    ];
}
