<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campagne;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_campagne_encours(){
        $campagnes = Campagne::where('etat','En cours')->paginate(10);
        return view('campagnes.index',compact('campagnes'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function get_campagne_terminee(){
        $campagnes = Campagne::where('etat','Terminée')->paginate(10);
        return view('campagnes.index',compact('campagnes'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function get_campagne_archivee(){
        $campagnes = Campagne::where('etat','Archivée')->paginate(10);
        return view('campagnes.index',compact('campagnes'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function get_campagne_planifiee(){
        $campagnes = Campagne::where('etat','Planifiée')->paginate(10);
        return view('campagnes.index',compact('campagnes'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function get_campagne_idee(){
        $campagnes = Campagne::where('etat','Idée')->paginate(10);
        return view('campagnes.index',compact('campagnes'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
