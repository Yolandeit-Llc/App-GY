<?php

namespace App\Http\Controllers;
use App\Models\Groupesansambassadeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupesansambassadeurController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $groupesansambassadeurs = Groupesansambassadeur::latest()->paginate(5);
        return view('groupesansambassadeurs.index',compact('groupesansambassadeurs'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function getAllSansAmb(){
        $groupesansambassadeurs=DB::table('groupes')
        ->leftjoin('ambassadeur_groupe','groupes.id_groupe' , '=' , 'ambassadeur_groupe.id_groupe')
        ->leftjoin('utilisateur','ambassadeur_groupe.id_ambassadeur' , '=' , 'utilisateur.id_utilisateur')
        ->select('groupes.id_groupe','groupes.nom','groupes.nb_membres','groupes.type','groupes.lieu','groupes.statut_integration','groupes.tag_recherche','utilisateur.prenom')
        ->whereNull('ambassadeur_groupe.id_ambassadeur')
        ->paginate(15);
        return view('groupesansambassadeurs.index',compact('groupesansambassadeurs'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
  }

    //Recherche Multi
    public function multisearch_sans_amb(Request $request){

        $multisearchnom = $request->get('multisearchnom');
        $multisearchtype = $request->get('multisearchtype');
        $multisearchtag = $request->get('multisearchtag');
        $multisearchlieu = $request->get('multisearchlieu');
        $multisearchstat = $request->get('multisearchstat');
        $nm = $request->get('nm');

        $groupesansambassadeurs= DB::table('groupes')
        ->leftjoin('ambassadeur_groupe','groupes.id_groupe' , '=' , 'ambassadeur_groupe.id_groupe')
        ->leftjoin('utilisateur','ambassadeur_groupe.id_ambassadeur' , '=' , 'utilisateur.id_utilisateur')
        ->select('groupes.id_groupe','groupes.nom','groupes.nb_membres','groupes.type','groupes.lieu','groupes.statut_integration','groupes.tag_recherche','utilisateur.prenom')
        ->whereNull('ambassadeur_groupe.id_ambassadeur')
        ->where('groupes.nom','LIKE','%'.$multisearchnom.'%')
        ->where('lieu','LIKE','%'.$multisearchlieu.'%')
        ->where('statut_integration','LIKE','%'.$multisearchstat.'%')
        ->where('groupes.type','LIKE','%'.$multisearchtype.'%')
        ->where('tag_recherche','LIKE','%'.$multisearchtag.'%')
        ->paginate($nm);

        return view('groupesansambassadeurs.index',['groupesansambassadeurs'=>$groupesansambassadeurs])
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    // Direction view create
    public function create()
    {
        return view('groupesansambassadeurs.create');
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

        Groupesansambassadeur::create($request->all());

        return redirect()->route('groupesansambassadeurs')
            ->with('success','');
    }

    // Direction vers le view de details du Groupesansambassadeur
    public function show(Groupesansambassadeur $groupesansambassadeur)
    {
        return view('groupesansambassadeurs.show',compact('groupesansambassadeur'));
    }

    // Direction vers le view de la modification du Groupesansambassadeur
    public function edit(Groupesansambassadeur $groupesansambassadeur)
    {
        return view('groupesansambassadeurs.edit',compact('groupesansambassadeur'));
    }

    // Processus de modification du Groupesansambassadeur
    public function update(Request $request, Groupesansambassadeur $groupesansambassadeur)
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

        $groupesansambassadeur->update($request->all());
        return redirect()->route('groupesansambassadeurs')
            ->with('success','');
    }

    // Procesuus de la suppression du Groupesansambassadeur
    public function destroy(Groupesansambassadeur $groupesansambassadeur)
    {
        $groupesansambassadeur->delete();
        return redirect()->route('groupesansambassadeurs')
                        ->with('success','');
    }
}
