<?php

namespace App\Http\Controllers;

use App\Models\Groupeavecsegmentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GroupeavecsegmentationController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $groupeavecsegmentations = DB::table('groupes')
            ->leftjoin('ambassadeur_groupe', 'groupes.id_groupe', '=', 'ambassadeur_groupe.id_groupe')
            ->leftjoin('utilisateur', 'ambassadeur_groupe.id_ambassadeur', '=', 'utilisateur.id_utilisateur')
            ->leftjoin('segment_groupe', 'groupes.id_groupe', '=', 'segment_groupe.id_groupe')
            ->leftjoin('segements', 'segment_groupe.id_segment', '=', 'segements.id_segment')
            ->select('groupes.id', 'groupes.id_groupe', 'groupes.nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.prenom')
            ->wherenotNull('segements.id_segment')
            ->paginate(15);

        return view('groupeavecsegmentations.index', compact('groupeavecsegmentations'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /*    public function subindex(Groupeavecsegmentation $groupeavecsegmentations,$perPage){
        $groupeavecsegmentations = Groupeavecsegmentation::sortable()->paginate($perPage);
        return view('groupeavecsegmentations.index',compact('groupeavecsegmentations'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }
*/
    public function getAllAvecSeg()
    {
        $groupeavecsegmentations = DB::table('groupes')
            ->select('groupes.id', 'groupes.id_groupe', 'groupes.nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.prenom')
            ->leftjoin('ambassadeur_groupe', 'groupes.id_groupe', '=', 'ambassadeur_groupe.id_groupe')
            ->leftjoin('utilisateur', 'ambassadeur_groupe.id_ambassadeur', '=', 'utilisateur.id_utilisateur')
            ->leftjoin('segment_groupe', 'groupes.id_groupe', '=', 'segment_groupe.id_groupe')
            ->leftjoin('segements', 'segment_groupe.id_segment', '=', 'segements.id_segment')
            ->groupBy('groupes.nom')
            ->whereNotNull('segements.id_segment')
            ->paginate(15);
        return view('groupeavecsegmentations.index', compact('groupeavecsegmentations'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function multisearch_g_a_segmentation(Request $request)
    {

        $multisearchnom = $request->get('multisearchnom');
        $multisearchtype = $request->get('multisearchtype');
        $multisearchtag = $request->get('multisearchtag');
        $multisearchlieu = $request->get('multisearchlieu');
        $multisearchstat = $request->get('multisearchstat');
        $nm = $request->get('nm');

        $groupeavecsegmentations = DB::table('groupes')
            ->select('groupes.id', 'groupes.id_groupe', 'groupes.nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.prenom')
            ->leftjoin('ambassadeur_groupe', 'groupes.id_groupe', '=', 'ambassadeur_groupe.id_groupe')
            ->leftjoin('utilisateur', 'ambassadeur_groupe.id_ambassadeur', '=', 'utilisateur.id_utilisateur')
            ->leftjoin('segment_groupe', 'groupes.id_groupe', '=', 'segment_groupe.id_groupe')
            ->leftjoin('segements', 'segment_groupe.id_segment', '=', 'segements.id_segment')
            ->groupBy('groupes.nom')
            ->whereNotNull('segements.id_segment')
            ->where('groupes.nom', 'LIKE', '%' . $multisearchnom . '%')
            ->where('lieu', 'LIKE', '%' . $multisearchlieu . '%')
            ->where('statut_integration', 'LIKE', '%' . $multisearchstat . '%')
            ->where('groupes.type', 'LIKE', '%' . $multisearchtype . '%')
            ->where('tag_recherche', 'LIKE', '%' . $multisearchtag . '%')
            ->paginate($nm);

        return view('groupeavecsegmentations.index', ['groupeavecsegmentations' => $groupeavecsegmentations])
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    // Direction view create
    public function create()
    {
        return view('groupeavecsegmentations.create');
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

        Groupeavecsegmentation::create($request->all());

        return redirect()->route('groupeavecsegmentations')
            ->with('success', '');
    }

    // Direction vers le view de details du Groupeavecsegmentation
    public function show(Groupeavecsegmentation $groupeavecsegmentation)
    {
        return view('groupeavecsegmentations.show', compact('groupeavecsegmentation'));
    }

    // Direction vers le view de la modification du Groupeavecsegmentation
    public function edit(Groupeavecsegmentation $groupeavecsegmentation)
    {
        return view('groupeavecsegmentations.edit', compact('groupeavecsegmentation'));
    }

    // Processus de modification du Groupeavecsegmentation
    public function update(Request $request, Groupeavecsegmentation $groupeavecsegmentation)
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

        $groupeavecsegmentation->update($request->all());
        return redirect()->route('groupeavecsegmentations')
            ->with('success', '');
    }

    // Procesuus de la suppression du Groupeavecsegmentation
    public function destroy(Groupeavecsegmentation $groupeavecsegmentation)
    {
        $groupeavecsegmentation->delete();
        return redirect()->route('groupeavecsegmentations')
            ->with('success', '');
    }
}
