<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Postmere extends Model
{
    use HasFactory;
    use Sortable;

    
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
        'interaction'    
    ];
        public $sortable = [ 'id_post','statut_scrappe', 'titre','type_media','legende','hashtag', 'portee','interaction'];

}
