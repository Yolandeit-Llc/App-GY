<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CherchepublicationsController extends Controller
{
    public function index()
    {
        return view('cherchepublications');
    }
}
