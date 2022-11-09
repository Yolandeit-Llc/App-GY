<?php

namespace App\Http\Controllers;
use App\Models\Questionad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionadController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $questionads = Questionad::latest()->paginate(10);
        return view('questionads.index',compact('questionads'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function getAll_quad(){
        $questionads=DB::table('groupes')
        ->join('question_adhesion_groupe','groupes.id_groupe','=','question_adhesion_groupe.id_groupe')
        ->join('questionads','question_adhesion_groupe.id_question','=','questionads.id_question')
        ->where('reponse',' ')
        ->orderBy('groupes.id_groupe')
        ->get();
        return view('questionads.index',compact('questionads'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    // Direction view create
    public function create()
    {
        return view('questionads.create');
    }

    // Processus de creation 
    public function store(Request $request)
    {
         $request->validate([
            'id_question',
            'nom',
            'theme',
            'nb_membres',
            'id_groupe',
            'question',
            'reponse',
            'reponse2',
            'reponse3',  
        ]);

    
        Questionad::create($request->all());
     
        return redirect()->route('questionads.index')
            ->with('success',''); 
    }
    
    // Direction vers le view de details du questionad
    public function show(Questionad $questionad)
    {
        return view('questionads.show',compact('questionad'));
    }

    // Direction vers le view de la modification du questionad
    public function edit(Questionad $questionad)
    {
        return view('questionads.edit',compact('questionad'));
    }

    // Processus de modification du questionad
    public function update(Request $request, Questionad $questionad)
    {
        $request->validate([
            'id_question',
            'nom',
            'theme',
            'nb_membres',
            'id_groupe',
            'question',
            'reponse',
            'reponse2',
            'reponse3',  
        ]);
    
        $questionad->update($request->all());
        return redirect()->route('questionads.index')
            ->with('success','');
    }

    // Procesuus de la suppression du questionad 
    public function destroy(Questionad $questionad)
    {
        $questionad->delete();
        return redirect()->route('questionads.index')
                        ->with('success','');
    }
}