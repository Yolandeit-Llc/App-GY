<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Segement;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SegementController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {

        $segements = Segement::join('segementations', 'segementations.nom_segmentation',
         '=', 'segements.nom_segmentation')
            ->get(['segements.*', 'segementations.nom_segmentation'])
            ->Paginate(15);
        return view('segements.index', compact('segements'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function searchsegment(Request $request)
    {
        $nom_segmentation = $request->get('nom_segmentation');
        $search = $request->get('search');
        $segements = DB::table('segements')

            ->where('nom_segmentation', 'LIKE', '%' . $nom_segmentation . '%')
            ->where('nom_segment', 'LIKE', '%' . $search . '%')
            ->paginate(5);
        return view('segements.index', ['segements' => $segements]);
    }


    // afficher list groupe segment de chaque id_segemnt dans fichier groupseg en précision id_segment manuellement
    public function groupeseg(Segement $segements, Utilisateur $utilisateur)
    {
        $utilisateur = Utilisateur::all();
        $segements = Segement::all();
        $groupeavecsegmentations = DB::table('groupes')
            ->leftjoin('ambassadeur_groupe', 'groupes.id_groupe', '=', 'ambassadeur_groupe.id_groupe')
            ->leftjoin('utilisateur', 'ambassadeur_groupe.id_ambassadeur', '=', 'utilisateur.id_utilisateur')
            ->leftjoin('segment_groupe', 'groupes.id_groupe', '=', 'segment_groupe.id_groupe')
            ->leftjoin('segements', 'segment_groupe.id_segment', '=', 'segements.id_segment')
            ->select('segements.id_segment', 'segements.nom_segment', 'groupes.id', 'groupes.id_groupe', 'groupes.nom', 'groupes.nb_membres', 'groupes.type', 'groupes.lieu', 'groupes.statut_integration', 'groupes.tag_recherche', 'utilisateur.prenom', 'utilisateur.Nom')
            ->where('segements.id_segment', 6)
            ->paginate(15);

        return view('segements.groupeseg', compact('groupeavecsegmentations', 'segements', 'utilisateur'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function getAllSegment()
    {
        $segements = DB::table('segements')

            ->get();
        return view('segements.index', compact('segements'));
    }

    // Direction view create
    public function create()
    {
        return view('segements.create');
    }



    // Processus de creation
    public function store(Request $request)
    {
        $request->validate([
            'id_segment',
            'nom_segment',
            'theme',
            'type',
            'caracteristique',
            'description',
            'nom_segmentation' => 'required',
            'nb_groupe',
        ]);

        Segement::create($request->all());

        return redirect()->route('segements')
            ->with('success', '');
    }

    public function show(Segement $segement, Groupe $groupe)
    {

        return view('segements.show', compact('segement', 'groupe'));
    }


    public function edit(Segement $segement)
    {
        // $segement = Segement::all();
        return view('segements.edit', compact('segement'));
    }

    public function update(Request $request, Segement $segement)
    {
        $request->validate([
            'id_segment',
            'nom_segment',
            'theme',
            'type',
            'caracteristique',
            'description',
            'nom_segmentation' => 'required',
            'nb_groupe',
        ]);

        $segement->update($request->all());
        return redirect()->route('segements')
            ->with('success', '');
    }

    public function destroy(Segement $segement)
    {
        $segement->delete();
        return redirect()->route('segements')
            ->with('success', '');
    }


    // supprime tout les groupe du segment dans la table segment groupe
    public function deleteSegment(Segement $segement, $id_segment)
    {

        $query = 'DELETE from segment_groupe
        WHERE segment_groupe.id_segment = ?';

        DB::delete($query, array($id_segment));
        return redirect()->route('deleteSegment', [$id_segment])
            ->with('success', '');
    }
}
