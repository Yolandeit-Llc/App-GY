<?php

namespace App\Http\Controllers;
use App\Models\Adhmanuelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdhmanuelleController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $adhmanuelles = Adhmanuelle::latest()->paginate(10);
        return view('adhmanuelles.index',compact('adhmanuelles'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function getAll_adh(){
        $adhmanuelles=DB::table('ambassadeur_groupe')
        ->join('groupes','ambassadeur_groupe.id_groupe','=','groupes.id_groupe')
        ->where('statut_adhesion','non adhéré')
        ->orWhere('statut_adhesion','à valider')
        ->get();
        return view('adhmanuelles.index',compact('adhmanuelles'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function multisearch_adh(Request $request)
    {
        $multisearchnom = $request->get('multisearchnom');
        $multisearchstatutadh = $request->get('multisearchstatutadh');
        $adhmanuelles= DB::table('ambassadeur_groupe')
        ->join('groupes','ambassadeur_groupe.id_groupe','=','groupes.id_groupe')
        ->where('statut_adhesion','non adhéré')
        ->orWhere('statut_adhesion','à valider')
        ->where('nom','LIKE','%'.$multisearchnom.'%')
        ->where('statut_adhesion','LIKE','%'.$multisearchstatutadh.'%')
        ->paginate(20);
        return view('adhmanuelles.index',['adhmanuelles'=>$adhmanuelles])
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }



    // Direction view create
    public function create()
    {
        return view('adhmanuelles.create');
    }

    // Processus de creation
    public function store(Request $request)
    {
         $request->validate([
            'id_groupe' => 'required',
            'nom',
            'personnalisation',
            'nb_membres',
            'theme',
            'type',
            'reglementation',
            'url_a_propos',
            'frequence_post_mois',
            'format_groupe',
            'lieu',
            'actif_supprime',
            'statut_releve',
            'date_releve',
            'statut_integration',
            'tag_recherche'
        ]);


        Adhmanuelle::create($request->all());

        return redirect()->route('adhmanuelles.index')
            ->with('success','');
    }

    // Direction vers le view de details du Adhmanuelle
    public function show(Adhmanuelle $adhmanuelle)
    {
        return view('adhmanuelles.show',compact('adhmanuelle'));
    }

    // Direction vers le view de la modification du Adhmanuelle
    public function edit(Adhmanuelle $adhmanuelle)
    {
        return view('adhmanuelles.edit',compact('adhmanuelle'));
    }

    // Processus de modification du Adhmanuelle
    public function update(Request $request, Adhmanuelle $adhmanuelle)
    {
        $request->validate([
            'id_groupe' => 'required',
            'nom',
            'personnalisation',
            'nb_membres',
            'theme',
            'type',
            'reglementation',
            'url_a_propos',
            'frequence_post_mois',
            'format_groupe',
            'lieu',
            'actif_supprime',
            'statut_releve',
            'date_releve',
            'statut_integration',
            'tag_recherche'
        ]);

        $adhmanuelle->update($request->all());
        return redirect()->route('adhmanuelles.index')
            ->with('success','');
    }

    // Procesuus de la suppression du Adhmanuelle
    public function destroy(Adhmanuelle $adhmanuelle)
    {
        $adhmanuelle->delete();
        return redirect()->route('adhmanuelles.index')
                        ->with('success','');
    }
}
