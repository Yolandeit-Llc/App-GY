<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomedashboardController extends Controller
{
    public function index()
    {
        return view('welcomedashboard');
    }
}
