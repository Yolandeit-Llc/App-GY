<?php

namespace App\Http\Controllers;

use PDO;
use PDOException;
use App\Models\Groupe;
use App\Models\Segment;
use App\Models\Campagne;
use Illuminate\Http\Request;
use App\Models\Groupecampagne;
use App\Models\segment_groupe;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GroupecampagneController extends Controller
{

    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index(Groupecampagne $id_campagne, Groupe $groupes)
    {

        $groupes = Groupe::all()->get('groupes.*');
        $groupecampagnes = Groupecampagne::join('campagnes', 'campagnes.id_campagne', '=', 'campagne_groupe.id_campagne')
            ->get(['campagne_groupe.*', 'campagnes.id_campagne']);
        $segs = DB::table('segements')->select('segements.nom_segment', 'segements.id_segment')
            ->get();
        $cpgrps = DB::table('campagne_groupe')->select('campagne_groupe.statut_publication')
            ->groupby('campagne_groupe.statut_publication')
            ->get('campagne_groupe');

        return view('groupecampagnes.index', compact('groupecampagnes', 'segs', 'cpgrps', 'id_campagne', 'groupes'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        session(['id_campagne' => 'value']);             // Récupérer la variable appellée dans la session de la table campagnes dans la table campagnegroupe


    }
    /*
    public function getcampagnes(){
        $groupecampagnes=DB::table('campagnes')
        ->select('campagnes.id_campagne', 'campagne_groupe.id_groupe', 'groupes.nom', 'campagne_groupe.statut_publication', 'segment_groupe.id_segment', 'campagnes.nom as C')
        ->join('campagne_groupe','campagnes.id_campagne','=','campagne_groupe.id_campagne')
        ->join('groupes','campagne_groupe.id_groupe','=','groupes.id_groupe')
        ->join('segment_groupe','segment_groupe.id_groupe','=','groupes.id_groupe')
        ->orderby('segment_groupe.id_segment','asc')
        ->get();
        return view('groupecampagnes.index',compact('groupecampagnes'));
    }
    */
    /*
    public function getseg(Request $request)
    {
        $search = $request->get('search');
        $groupecampagnes= DB::table('campagnes')
        ->select('campagnes.id_campagne', 'campagne_groupe.id_groupe', 'groupes.nom', 'campagne_groupe.statut_publication', 'segment_groupe.id_segment', 'campagnes.nom as C')
        ->join('campagne_groupe','campagnes.id_campagne','=','campagne_groupe.id_campagne')
        ->join('groupes','campagne_groupe.id_groupe','=','groupes.id_groupe')
        ->join('segment_groupe','segment_groupe.id_groupe','=','groupes.id_groupe')
        ->where('id_segment','LIKE','%'.$search.'%')
        ->paginate(100);
        return view('groupecampagnes.index',['groupecampagnes'=>$groupecampagnes]);
    }
*/

    // Direction view create
    public function create()
    {
        return view('groupecampagnes.create');
    }

    // Processus de creation
    public function store(Request $request)
    {
        $request->validate([
            'id_campagne',
            'id_groupe',
            'statut_publication',
            'statut_recherche',
            'traitement_publication',
        ]);

        Groupecampagne::create($request->all());

        return redirect()->route('groupecampagnes.store')
            ->with('success', '');
    }

    // Direction vers le view de details du Groupecampagne
    public function show(Groupecampagne $groupecampagne, segment_groupe $segementgroupe, Campagne $campagne)
    {
        $liste_groupe_campagne = DB::select('select id_campagne from campagne_groupe where id_campagne=?', ['$value->id_campagne']);

        return view('groupecampagnes.show', compact('groupecampagne', 'liste_groupe_campagne', 'segementgroupe'));
    }

    // Direction vers le view de la modification du Groupecampagne
    public function edit(Groupecampagne $groupecampagne)
    {
        return view('groupecampagnes.edit', compact('groupecampagne'));
    }

    // Processus de modification du Groupecampagne
    public function update(Request $request, Groupecampagne $groupecampagne)
    {
        $request->validate([
            'id_campagne',
            'id_groupe',
            'statut_publication',
            'statut_recherche',
            'traitement_publication',

        ]);


        $groupecampagne->update($request->all());
        return redirect()->route('groupecampagnes.index')
            ->with('success', '');
    }

    // Procesuus de la suppression du Groupecampagne
    public function destroy(Groupecampagne $groupecampagne)
    {
        $groupecampagne->delete();
        return redirect()->route('groupecampagnes.index')
            ->with('success', '');
    }


    // Procesuus de ajoute une list groupe segments pour chaque segment dans la table groupe campagne


    //     public function cherchSeg(Groupecampagne $groupecampagne,$id_segment,Campagne $campagne) {
    //        // $seg_group = DB::select('select * from segment_groupe where i_segment = ?', ['$id_segment']);
    //        $id_g=$campagne->id_campagne;
    //        $array1=explode(",",$id_g);
    //                     //  $grp_seg = DB::select('select id_segment from segment_groupe where id_segment=?',['$seg_choisi']);
    //                      $insertion=  DB::table('campagne_groupe')->insert([
    //                         ['id_groupe' => 'select id_segment from segment_groupe where id_segment=?'],
    //                         ['id_campagne'=> $array1[0] ]

    //                    ]);
    // // $insertion=DB::insert('insert into campganges_groupe id_groupe  values ('select * from segment_groupe where id_segment=?',['$seg_choisi'])'):
    // // $insertion = DB::insert('insert into campgange_groupes (id_groupe) values (select id_groupe from segment_groupe where id_segment=?)');

    //         return view('groupecampagnes',compact('groupecampagne','id_segment','insertion'));

    // return redirect()->route('cherchSeg' , [$id_segment] ,[$seg_group] )
    //                 ->with('success','');
    // }







    // public function insert(Groupecampagne $groupecampagne){

    //     $insertion = Groupecampagne:: OrderBy('id_campagne')->get();
    //     $reqz = Groupecampagne::insertGetID(array('id_groupe' => 'djazia'));


    //   return view('groupecampagnes.insert',compact('groupecampagne', 'insertion','reqz'));
    // }
    // public function insert_camp(Request $request)
    // {


    //     dd("cool");
    // }

    
}
