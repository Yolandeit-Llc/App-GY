<?php

namespace App\Http\Controllers;
use App\Models\Postmere;
use Illuminate\Http\Request;

class PostMereController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $postmeres = Postmere::sortable()->paginate(10);
        return view('postmeres.index',compact('postmeres'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    // Direction view create
    public function create()
    {
        return view('postmeres.create');
    }

    // Processus de creation 
    public function store(Request $request)
    {
         $request->validate([
            'id_post'=>'required',
            'id_campagne' => 'required',
            'url_post',
            'statut_scrappe',
            'titre',
            'type_media',
            'legende',
            'hashtag',
            'portee',
            'interaction'
        ]);
    
        Postmere::create($request->all());
     
        return redirect()->route('postmeres.index') 
            ->with('success','');
    }
    
    public function show(Postmere $postmere)
    {
        return view('postmeres.show',compact('postmere'));
    }

    public function edit(Postmere $postmere)
    {
        return view('postmeres.edit',compact('postmere'));
    }

    public function update(Request $request, Postmere $postmere)
    {
        $request->validate([
            'id_post'=>'required',
            'id_campagne' => 'required',
            'url_post',
            'statut_scrappe',
            'titre',
            'type_media',
            'legende',
            'hashtag',
            'portee',
            'interaction'
        ]);
    
        $postmere->update($request->all());
        return redirect()->route('postmeres.index')
            ->with('success','');
    }

    public function destroy(Postmere $postmere)
    {
        $postmere->delete();
        return redirect()->route('postmeres.index')
                        ->with('success','');
    }
}