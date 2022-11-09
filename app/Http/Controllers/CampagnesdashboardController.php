<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampagnesdashboardController extends Controller
{
    public function index()
    {
        return view('campagnesdashboard');
    }
}
