<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Segement;
use App\Models\Segementation;
use App\Models\segment_groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GroupeController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index(Request $request)
    {
        $perPage = 2;
        $groupes = Groupe::sortable()->paginate(15)->withQueryString();
        return view('groupes.index', compact('groupes', 'perPage'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function multisearch(Request $request)
    {

        $multisearchnom = $request->get('multisearchnom');
        $multisearchtype = $request->get('multisearchtype');
        $multisearchtag = $request->get('multisearchtag');
        $multisearchlieu = $request->get('multisearchlieu');
        $multisearchstat = $request->get('multisearchstat');
        $groupes = DB::table('groupes')

            ->where('lieu', 'LIKE', '%' . $multisearchlieu . '%')
            ->where('statut_integration', 'LIKE', '%' . $multisearchstat . '%')
            ->where('type', 'LIKE', '%' . $multisearchtype . '%')
            ->where('tag_recherche', 'LIKE', '%' . $multisearchtag . '%')
            ->where('nom', 'LIKE', '%' . $multisearchnom . '%')
            ->paginate(20);

        return view('groupes.index', ['groupes' => $groupes]);
    }

    // Direction view create

    public function create()
    {
        return view('groupes.create');
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

        Groupe::create($request->all());

        return redirect()->route('groupes.index')
            ->with('success', '');
    }

    // Direction vers le view de details du groupe
    public function show(Groupe $groupe, Segement $segement, Segementation $segementation)
    {

        return view('groupes.show', compact('groupe', 'segement', 'segementation'));
    }

    // Direction vers le view de la modification du groupe
    public function edit(Groupe $groupe)
    {
        return view('groupes.edit', compact('groupe'));
    }

    // Processus de modification du groupe
    public function update(Request $request, Groupe $groupe)
    {
        $request->validate([

            'id_groupe' => 'required',
            'nom' => 'required',
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

        $groupe->update($request->all());
        return redirect()->route('groupes.index')
            ->with('success', '');
    }

    // Procesuus de la suppression du groupe
    public function destroy(Groupe $groupe)
    {
        $groupe->delete();
        return redirect()->route('groupes.index')
            ->with('success', '');
    }

    // Procesuus de la suppression plusieur groupe en meme temps
    public function deleteall_g(Request $request)
    {
        $ids = $request->get('ids');
        Groupe::whereIn('id', $ids)->delete();
        return redirect('groupes');
    }
    public function getAllAvecAmb()
    {
        $groupeavecambassadeurs = DB::table('groupes')

            ->leftJoin('ambassadeur_groupe', 'groupes.id_groupe', '=', 'ambassadeur_groupe.id_groupe')
            ->leftJoin('utilisateur', 'ambassadeur_groupe.id_ambassadeur', '=', 'utilisateur.id_utilisateur')
            ->select('groupes.id', 'groupes.id_groupe', 'groupes.nom as groupes_nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.nom as utilisateur_nom', 'utilisateur.prenom')
            ->whereNotNull('ambassadeur_groupe.id_ambassadeur')
            ->groupBy('groupes.nom')
            ->paginate(15);
        return view('groupeavecambassadeurs.index', compact('groupeavecambassadeurs'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function getAllSansAmb()
    {
        $groupesansambassadeurs = DB::table('groupes')
            ->leftjoin('ambassadeur_groupe', 'groupes.id_groupe', '=', 'ambassadeur_groupe.id_groupe')
            ->leftjoin('utilisateur', 'ambassadeur_groupe.id_ambassadeur', '=', 'utilisateur.id_utilisateur')
            ->select('groupes.id', 'groupes.id_groupe', 'groupes.nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.prenom')
            ->whereNull('ambassadeur_groupe.id_ambassadeur')
            ->paginate(15);
        return view('groupesansambassadeurs.index', compact('groupesansambassadeurs'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function multisearch_s_segment(Request $request)
    {

        $multisearchnom = $request->get('multisearchnom');
        $multisearchtype = $request->get('multisearchtype');
        $multisearchtag = $request->get('multisearchtag');
        $multisearchlieu = $request->get('multisearchlieu');
        $multisearchstat = $request->get('multisearchstat');
        $nm = $request->get('nm');

        $groupesanssegments = DB::table('groupes')
            ->leftjoin('ambassadeur_groupe', 'groupes.id_groupe', '=', 'ambassadeur_groupe.id_groupe')
            ->leftjoin('utilisateur', 'ambassadeur_groupe.id_ambassadeur', '=', 'utilisateur.id_utilisateur')
            ->leftjoin('segment_groupe', 'groupes.id_groupe', '=', 'segment_groupe.id_groupe')
            ->leftjoin('segements', 'segment_groupe.id_segment', '=', 'segements.id_segment')
            ->select('groupes.id', 'groupes.id_groupe', 'groupes.nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.prenom')
            ->whereNull('segements.id_segment')
            ->where('groupes.nom', 'LIKE', '%' . $multisearchnom . '%')
            ->where('lieu', 'LIKE', '%' . $multisearchlieu . '%')
            ->where('statut_integration', 'LIKE', '%' . $multisearchstat . '%')
            ->where('groupes.type', 'LIKE', '%' . $multisearchtype . '%')
            ->where('tag_recherche', 'LIKE', '%' . $multisearchtag . '%')
            ->paginate($nm);

        return view('groupesanssegments.index', ['groupesanssegments' => $groupesanssegments])
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function getAllAvecSeg()
    {
        $groupeavecsegmentations = DB::table('groupes')
            ->leftjoin('ambassadeur_groupe', 'groupes.id_groupe', '=', 'ambassadeur_groupe.id_groupe')
            ->leftjoin('utilisateur', 'ambassadeur_groupe.id_ambassadeur', '=', 'utilisateur.id_utilisateur')
            ->leftjoin('segment_groupe', 'groupes.id_groupe', '=', 'segment_groupe.id_groupe')
            ->leftjoin('segements', 'segment_groupe.id_segment', '=', 'segements.id_segment')
            ->whereNull('segements.id_segment')
            ->groupBy('groupes.nom')
            ->paginate(15);
        return view('groupeavecsegmentations.index', compact('groupeavecsegmentations'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
