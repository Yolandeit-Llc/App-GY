<?php

namespace App\Http\Controllers;
use App\Models\Postgroupe;
use Illuminate\Http\Request;

class PostGroupeController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $data = Postgroupe::latest()->paginate(10);
        return view('postgroupes.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    // Direction view create
    public function create()
    {
        return view('postgroupes.create');
    }

    // Processus de creation 
    public function store(Request $request)
    {
         $request->validate([
            'id_post'=>'required',
            'id_campagne'=>'required',
            'url_post',
            'statut_scrappe',
            'titre',
            'type_media',
            'legende',
            'hashtag',
            'portee',
            'interaction',

        ]);
    
        Postgroupe::create($request->all());
     
        return redirect()->route('postgroupes.index') 
            ->with('success','');
    }
    
    public function show(Postgroupe $postgroupe)
    {
        return view('postgroupes.show',compact('postgroupe'));
    }

    public function edit(Postgroupe $postgroupe)
    {
        return view('postgroupes.edit',compact('postgroupe'));
    }

    public function update(Request $request, Postgroupe $postgroupe)
    {
        $request->validate([
            'id_post'=>'required',
            'id_campagne'=>'required',
            'url_post',
            'statut_scrappe',
            'titre',
            'type_media',
            'legende',
            'hashtag',
            'portee',
            'interaction',
        ]);
    
        $postgroupe->update($request->all());
        return redirect()->route('postgroupes.index')
            ->with('success','');
    }

    public function destroy(Postgroupe $postgroupe)
    {
        $postgroupe->delete();
        return redirect()->route('postgroupes.index')
                        ->with('success','');
    }
}