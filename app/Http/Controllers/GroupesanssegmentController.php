<?php

namespace App\Http\Controllers;
use App\Models\Groupesanssegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GroupesanssegmentController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $groupesanssegments=DB::table('groupes')
        ->leftjoin('ambassadeur_groupe','groupes.id_groupe' , '=' , 'ambassadeur_groupe.id_groupe')
        ->leftjoin('utilisateur','ambassadeur_groupe.id_ambassadeur' , '=' , 'utilisateur.id_utilisateur')
        ->leftjoin('segment_groupe','groupes.id_groupe' , '=' , 'segment_groupe.id_groupe')
        ->leftjoin('segements','segment_groupe.id_segment' , '=' , 'segements.id_segment')
        ->select('groupes.id','groupes.id_groupe','groupes.nom','groupes.nb_membres','groupes.type','groupes.lieu','groupes.statut_integration','groupes.tag_recherche','utilisateur.prenom')
        ->whereNull('segements.id_segment')
        ->paginate(15);
        return view('groupesanssegments.index',compact('groupesanssegments'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function multisearch_s_segment(Request $request){

        $multisearchnom = $request->get('multisearchnom');
        $multisearchtype = $request->get('multisearchtype');
        $multisearchtag = $request->get('multisearchtag');
        $multisearchlieu = $request->get('multisearchlieu');
        $multisearchstat = $request->get('multisearchstat');
        $nm = $request->get('nm');

        $groupesanssegments= DB::table('groupes')
        ->leftjoin('ambassadeur_groupe','groupes.id_groupe' , '=' , 'ambassadeur_groupe.id_groupe')
        ->leftjoin('utilisateur','ambassadeur_groupe.id_ambassadeur' , '=' , 'utilisateur.id_utilisateur')
        ->leftjoin('segment_groupe','groupes.id_groupe' , '=' , 'segment_groupe.id_groupe')
        ->leftjoin('segements','segment_groupe.id_segment' , '=' , 'segements.id_segment')
        ->select('groupes.id','groupes.id_groupe','groupes.nom','groupes.nb_membres','groupes.type','groupes.lieu','groupes.statut_integration','groupes.tag_recherche','utilisateur.prenom')
        ->whereNull('segements.id_segment')
        ->where('groupes.nom','LIKE','%'.$multisearchnom.'%')
        ->where('lieu','LIKE','%'.$multisearchlieu.'%')
        ->where('statut_integration','LIKE','%'.$multisearchstat.'%')
        ->where('groupes.type','LIKE','%'.$multisearchtype.'%')
        ->where('tag_recherche','LIKE','%'.$multisearchtag.'%')
        ->paginate($nm);

        return view('groupesanssegments.index',['groupesanssegments'=>$groupesanssegments])
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    // Direction view create
    public function create()
    {
        return view('groupesanssegments.create');
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
            'tag_recherche',
            'nom_ambassadeur',
            'id_ambassadeur'
        ]);

        Groupesanssegment::create($request->all());

        return redirect()->route('groupesanssegments.index')
            ->with('success','');
    }

    // Direction vers le view de details du Groupesanssegment
    public function show(Groupesanssegment $groupesanssegment)
    {
        return view('groupesanssegments.show',compact('groupesanssegment'));
    }

    // Direction vers le view de la modification du Groupesanssegment
    public function edit(Groupesanssegment $groupesanssegment)
    {
        return view('groupesanssegments.edit',compact('groupesanssegment'));
    }

    // Processus de modification du Groupesanssegment
    public function update(Request $request, Groupesanssegment $groupesanssegment)
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
            'tag_recherche',
            'nom_ambassadeur',
            'id_ambassadeur'
        ]);

        $groupesanssegment->update($request->all());
        return redirect()->route('groupesanssegments.index')
            ->with('success','');
    }

    // Procesuus de la suppression du Groupesanssegment
    public function destroy(Groupesanssegment $groupesanssegment)
    {
        $groupesanssegment->delete();
        return redirect()->route('groupesanssegments.index')
                        ->with('success','');
    }
}
