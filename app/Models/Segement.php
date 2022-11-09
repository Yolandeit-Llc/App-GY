<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segement extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_segment';
    protected $table = 'segements';
    protected $fillable = [
        'id_segment',
        'nom_segment',
        'theme',
        'type',
        'caracteristique',
        'description',
        'nom_segmentation',
        'nb_groupe',
     ];

}
