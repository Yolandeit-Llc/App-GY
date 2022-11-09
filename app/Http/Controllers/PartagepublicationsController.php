<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartagepublicationsController extends Controller
{
    public function index()
    {
        return view('partagepublications');
    }
}
