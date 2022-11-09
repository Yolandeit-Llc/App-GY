<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupesdashboardController extends Controller
{
    public function index()
    {
        return view('groupesdashboard');
    }
}
