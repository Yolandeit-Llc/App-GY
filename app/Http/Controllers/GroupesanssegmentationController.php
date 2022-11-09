<?php

namespace App\Http\Controllers;
use App\Models\Groupesanssegmentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupesanssegmentationController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $groupesanssegmentations = Groupesanssegmentation::latest()->paginate(10);
        return view('groupesanssegmentations.index',compact('groupesanssegmentations'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function getAllSansSegmentation(){
        $groupesanssegmentations=DB::table('groupes')
        ->select('groupes.id','groupes.id_groupe', 'groupes.nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.nom as nom_amba', 'utilisateur.prenom as prenom_amba', 'segementations.id_segmentation', 'segements.id_segment')
        ->leftJoin('ambassadeur_groupe','groupes.id_groupe','=','ambassadeur_groupe.id_groupe')
        ->leftJoin('utilisateur','ambassadeur_groupe.id_ambassadeur','=','utilisateur.id_utilisateur')
        ->leftJoin('segment_groupe','groupes.id_groupe','=','segment_groupe.id_groupe')
        ->leftJoin('segements','segment_groupe.id_segment','=','segements.id_segment')
        ->leftJoin('segementations','segements.id_segmentation','=','segementations.id_segmentation')
        ->whereNull('segementations.id_segmentation')
        ->paginate(15);
        return view('groupesanssegmentations.index',compact('groupesanssegmentations'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function multisearch_g_s_segmentation(Request $request){

        $multisearchnom = $request->get('multisearchnom');
        $multisearchtype = $request->get('multisearchtype');
        $multisearchtag = $request->get('multisearchtag');
        $multisearchlieu = $request->get('multisearchlieu');
        $multisearchstat = $request->get('multisearchstat');
        $nm = $request->get('nm');

        $groupesanssegmentations= DB::table('groupes')
        ->select('groupes.id','groupes.id_groupe', 'groupes.nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.nom as nom_amba', 'utilisateur.prenom as prenom_amba', 'segementations.id_segmentation', 'segements.id_segment')
        ->leftJoin('ambassadeur_groupe','groupes.id_groupe','=','ambassadeur_groupe.id_groupe')
        ->leftJoin('utilisateur','ambassadeur_groupe.id_ambassadeur','=','utilisateur.id_utilisateur')
        ->leftJoin('segment_groupe','groupes.id_groupe','=','segment_groupe.id_groupe')
        ->leftJoin('segements','segment_groupe.id_segment','=','segements.id_segment')
        ->leftJoin('segementations','segements.id_segmentation','=','segementations.id_segmentation')
        ->whereNull('segementations.id_segmentation')
        ->where('groupes.nom','LIKE','%'.$multisearchnom.'%')
        ->where('lieu','LIKE','%'.$multisearchlieu.'%')
        ->where('statut_integration','LIKE','%'.$multisearchstat.'%')
        ->where('groupes.type','LIKE','%'.$multisearchtype.'%')
        ->where('tag_recherche','LIKE','%'.$multisearchtag.'%')
        ->paginate($nm);

        return view('groupesanssegmentations.index',['groupesanssegmentations'=>$groupesanssegmentations])
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    // Direction view create
    public function create()
    {
        return view('groupesanssegmentations.create');
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
        ]);

        Groupesanssegmentation::create($request->all());

        return redirect()->route('groupesanssegmentations')
            ->with('success','');
    }

    // Direction vers le view de details du Groupesanssegmentation
    public function show(Groupesanssegmentation $groupesanssegmentation)
    {
        return view('groupesanssegmentations.show',compact('groupesanssegmentation'));
    }

    // Direction vers le view de la modification du Groupesanssegmentation
    public function edit(Groupesanssegmentation $groupesanssegmentation)
    {
        return view('groupesanssegmentations.edit',compact('groupesanssegmentation'));
    }

    // Processus de modification du Groupesanssegmentation
    public function update(Request $request, Groupesanssegmentation $groupesanssegmentation)
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
        ]);

        $groupesanssegmentation->update($request->all());
        return redirect()->route('groupesanssegmentations')
            ->with('success','');
    }

    // Procesuus de la suppression du Groupesanssegmentation
    public function destroy(Groupesanssegmentation $groupesanssegmentation)
    {
        $groupesanssegmentation->delete();
        return redirect()->route('groupesanssegmentations')
                        ->with('success','');
    }
}
