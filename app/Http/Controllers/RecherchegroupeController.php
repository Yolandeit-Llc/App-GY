<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecherchegroupeController extends Controller
{
    public function index()
    {
        return view('recherchenouveauxgroupe');
    }
}
