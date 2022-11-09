<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Segement;
use App\Models\Segementation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class SegementationController extends Controller

{



    //  Une fois on depasse 5 lignes par tableau Ca d'affiche
    public function index()
    {
        $segementations = Segementation::latest()->paginate(10);
        return view('segementations.index', compact('segementations'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function getAllSegmentation()
    {
        $segementations = DB::table('segementations')

            ->get();
        return view('segementations.index', compact('segementations'));
    }

    // Direction view create
    public function create()
    {
        return view('segementations.create');
    }

    // Processus de creation
    public function store(Request $request)
    {
        $request->validate([
            'id_segmentation',
            'nom_segmentation',
            'criteres',
            'description',
            'nb_groupe'
        ]);

        Segementation::create($request->all());

        return redirect()->route('segementations')
            ->with('success', '');
    }

    public function show(Segementation $segementation, Groupe $groupe, Segement $segement)
    {

        //$segement= Segement::get('id_segment');
        return view('segementations.show', compact('segementation', 'groupe', 'segement'));
    }

    //     public function showgrpseg(Segementation $segementations)
    //     {

    //         $segementations= DB::table('segementations')
    //         ->leftjoin('segements', 'segements.nom_segmentation', '=', 'segementations.nom_segmentation')
    // ->select('segementations.id_segmentation','segements.id_segment' ,'segements.nom_segment' , 'segements.nom_segmentation ')
    //         ->where('segementations.id_segmentation',2);

    //         return view('segementations.showgrpseg',compact('segementations'));
    //     }

    public function edit(Segementation $segementation)
    {
        return view('segementations.edit', compact('segementation'));
    }

    public function update(Request $request, Segementation $segementation)
    {
        $request->validate([
            'id_segmentation',
            'nom_segmentation',
            'criteres',
            'description',
            'nb_groupe'

        ]);

        $segementation->update($request->all());
        return redirect()->route('segementations')
            ->with('success', '');
    }

    public function destroy(Segementation $segementation)
    {
        $segementation->delete();
        return redirect()->route('segementations')
            ->with('success', '');
    }



    public function delete(Segementation $segementation, $id = null)
    {


        Segementation::destroy($id);

        return redirect()->route('segementationsDelete', [$id])
            ->with('success', '');
    }
}
