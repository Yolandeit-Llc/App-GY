<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class segment_groupe extends Model
{
    use HasFactory;

    protected $table = 'segment_groupe';
    protected $fillable = [
    'id_segment',
       'id_groupe'
     ];
}
