<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelevecentController extends Controller
{
    public function index()
    {
        return view('relevecentposts');
    }
}
