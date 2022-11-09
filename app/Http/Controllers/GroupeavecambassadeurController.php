<?php

namespace App\Http\Controllers;
use App\Models\Groupeavecambassadeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GroupeavecambassadeurController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $groupeavecambassadeurs=DB::table('groupes')
        ->leftjoin('ambassadeur_groupe','groupes.id_groupe' , '=' , 'ambassadeur_groupe.id_groupe')
        ->leftjoin('utilisateur','ambassadeur_groupe.id_ambassadeur' , '=' , 'utilisateur.id_utilisateur')
        ->select('groupes.id','groupes.id_groupe','groupes.nom','groupes.nb_membres','groupes.type','groupes.lieu','groupes.statut_integration','groupes.tag_recherche','utilisateur.prenom')
        ->wherenotNull('ambassadeur_groupe.id_ambassadeur')
        ->paginate(15);
        return view('groupeavecambassadeurs.index',compact('groupeavecambassadeurs'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    // public function getAllAvecAmb(){
    //     $groupeavecambassadeurs=DB::table('groupes')
    //     ->leftJoin('ambassadeur_groupe','groupes.id_groupe','=','ambassadeur_groupe.id_groupe')
    //     ->leftJoin('utilisateur','ambassadeur_groupe.id_ambassadeur','=','utilisateur.id_utilisateur')
    //     ->select('groupes.id','groupes.id_groupe', 'groupes.nom as groupes_nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.nom as utilisateur_nom', 'utilisateur.prenom')
    //     ->whereNotNull('id_ambassadeur')
    //     ->groupBy('groupes.nom')
    //     ->paginate(15);
    //     return view('groupeavecambassadeurs.index',compact('groupeavecambassadeurs'))
    //     ->with('i', (request()->input('page', 1) - 1) * 5);

    // }

    //Recherche Multi
    public function multisearch_amb(Request $request){

        $multisearchnom = $request->get('multisearchnom');
        $multisearchtype = $request->get('multisearchtype');
        $multisearchtag = $request->get('multisearchtag');
        $multisearchlieu = $request->get('multisearchlieu');
        $multisearchstat = $request->get('multisearchstat');
        $nm = $request->get('nm');
        $groupeavecambassadeurs= DB::table('groupes')
        ->leftJoin('ambassadeur_groupe','groupes.id_groupe','=','ambassadeur_groupe.id_groupe')
        ->leftJoin('utilisateur','ambassadeur_groupe.id_ambassadeur','=','utilisateur.id_utilisateur')
        ->select('groupes.id','groupes.id_groupe', 'groupes.nom as groupes_nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.nom as utilisateur_nom', 'utilisateur.prenom')
        ->whereNotNull('id_ambassadeur')
        ->groupBy('groupes.nom')
        ->where('groupes.nom','LIKE','%'.$multisearchnom.'%')
        ->where('lieu','LIKE','%'.$multisearchlieu.'%')
        ->where('statut_integration','LIKE','%'.$multisearchstat.'%')
        ->where('groupes.type','LIKE','%'.$multisearchtype.'%')
        ->where('tag_recherche','LIKE','%'.$multisearchtag.'%')
        ->paginate($nm);

        return view('groupeavecambassadeurs.index',['groupeavecambassadeurs'=>$groupeavecambassadeurs])
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }



    // Direction view create
    public function create()
    {
        return view('groupeavecambassadeurs.create');
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

        Groupeavecambassadeur::create($request->all());

        return redirect()->route('groupeavecambassadeurs')
            ->with('success','');
    }

    // Direction vers le view de details du Groupeavecambassadeur
    public function show(Groupeavecambassadeur $groupeavecambassadeur)
    {
        return view('groupeavecambassadeurs.show',compact('groupeavecambassadeur'));
    }

    // Direction vers le view de la modification du Groupeavecambassadeur
    public function edit(Groupeavecambassadeur $groupeavecambassadeur)
    {
        return view('groupeavecambassadeurs.edit',compact('groupeavecambassadeur'));
    }

    // Processus de modification du Groupeavecambassadeur
    public function update(Request $request, Groupeavecambassadeur $groupeavecambassadeur)
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

        $groupeavecambassadeur->update($request->all());
        return redirect()->route('groupeavecambassadeurs')
            ->with('success','');
    }


    // Procesuus de la suppression du Groupeavecambassadeur
    public function destroy(Groupeavecambassadeur $groupeavecambassadeur)
    {
        $groupeavecambassadeur->delete();
        return redirect()->route('groupeavecambassadeurs')
                        ->with('success','');
    }

    //delete function
    // on passe l'id ambassadeur
    //delete * from groupe_ambassadeur where
}
