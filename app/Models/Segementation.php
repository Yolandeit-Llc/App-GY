<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segementation extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_segmentation';
    protected $table = 'segementations';
    protected $fillable = [
        'id_segmentation',
        'nom_segmentation',
        'criteres',
        'description',
        'nb_groupe'
    ];
}
 