<?php

namespace App\Http\Controllers;
use App\Models\Postpartage;
use Illuminate\Http\Request;

class PostPartageController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $postpartages = Postpartage::sortable()->paginate(10);
        return view('postpartages.index',compact('postpartages'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    // Direction view create
    public function create()
    {
        return view('postpartages.create');
    }

    // Processus de creation 
    public function store(Request $request)
    {
         $request->validate([
            'id_post'=>'required',
            'id_groupe' => 'required',
            'nom',
            'prenom',
            'message_personnalise',
            'statut',
            'id_utilisateur'
        ]);
    
        Postpartage::create($request->all());
     
        return redirect()->route('postpartages.index') 
            ->with('success','');
    }
    
    public function show(Postpartage $postpartage)
    {
        return view('postpartages.show',compact('postpartage'));
    }

    public function edit(Postpartage $postpartage)
    {
        return view('postpartages.edit',compact('postpartage'));
    }

    public function update(Request $request, Postpartage $postpartage)
    {
        $request->validate([
            'id_post'=>'required',
            'id_groupe' => 'required',
            'nom',
            'prenom',
            'message_personnalise',
            'statut',
            'id_utilisateur'
        ]);
    
        $postpartage->update($request->all());
        return redirect()->route('postpartages.index')
            ->with('success','');
    }

    public function destroy(Postpartage $postpartage)
    {
        $postpartage->delete();
        return redirect()->route('postpartages.index')
                        ->with('success','');
    }
}