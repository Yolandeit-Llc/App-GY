<?php

namespace App\Http\Controllers;

use App\Models\Ambassadeur;
use App\Models\ambassadeurGroupe;
use App\Models\Groupe;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class AmbassadeurController extends Controller
{
    // // Direction view index
    public function index()
    {
        $utilisateur = Utilisateur::all();
        $ambassadeurs = Ambassadeur::join('utilisateur', 'utilisateur.id_utilisateur', '=', 'ambassadeurs.id_ambassadeur')
            ->get(['ambassadeurs.*', 'utilisateur.Nom', 'utilisateur.prenom', 'utilisateur.url_utilisateur']);
        return view('ambassadeurs.index', compact('ambassadeurs', 'utilisateur'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function searchamb(Request $request)
    {
        $search = $request->get('search');
        $auth = $request->get('auth');
        $ambassadeurs = Ambassadeur::join('utilisateur', 'utilisateur.id_utilisateur', '=', 'ambassadeurs.id_ambassadeur')
            ->where('Nom', 'LIKE', '%' . $search . '%')
            ->where('authentification_facebook', 'LIKE', '%' . $auth . '%')
            ->paginate(5);
        return view('ambassadeurs.index', ['ambassadeurs' => $ambassadeurs]);
    }




    // public function getAllamb(){
    //     $segements=DB::table('ambassadeurs')
    //     ->select('ambassadeurs.id_utilisateur', 'login', 'mdp', 'authentification_facebook', 'utilisateur.Nom', 'utilisateur.prenom', DB::raw("(  (count(id_groupe)  ) )  as `nb_groupe` "))
    //         ->leftJoin('ambassadeurs','ambassadeur_groupe.id_ambassadeur','=','ambassadeurs.id_utilisateur')
    //         ->join('utilisateur','ambassadeurs.id_utilisateur','=','utilisateur.id_utilisateur')
    //         ->groupBy('ambassadeurs.id_utilisateur')
    //         ->get();
    //     return view('ambassadeurs.index',compact('ambassadeurs'))
    //     ->with('i', (request()->input('page', 1) - 1) * 5);
    // }
    // public function getAll(){
    //     $ambassadeurs=DB::table('ambassadeur_groupe')
    //     ->select('ambassadeurs.id_utilisateur', 'login', 'mdp', 'authentification_facebook', 'utilisateur.Nom', 'utilisateur.prenom', DB::raw("(  (count(id_groupe)  ) )  as `nb_groupe` "))
    //     ->leftJoin('ambassadeurs','ambassadeur_groupe.id_ambassadeur','=','ambassadeurs.id_utilisateur')
    //     ->join('utilisateur','ambassadeurs.id_utilisateur','=','utilisateur.id_utilisateur')
    //     ->groupBy('ambassadeurs.id_utilisateur')
    //     ->get();
    //     return view('ambassadeurs.index',compact('ambassadeurs'))
    //     ->with('i', (request()->input('page', 1) - 1) * 5);

    // }


    // // Direction view create
    public function create()
    {
        return view('ambassadeurs.create');
    }



    // Processus de creation
    public function store(Request $request)
    {
        $request->validate([
            'id_utilisateur',
            'login',
            'mdp',
            'authentification_facebook',
            'cookies',
        ]);

        Ambassadeur::create($request->all());

        return redirect()->route('ambassadeurs')
            ->with('success', '');
    }

    // Direction vers le view de details du Ambassadeur
    public function show(Ambassadeur $ambassadeur)
    {
        return view('ambassadeurs.show', compact('ambassadeur'));
    }

    // Direction vers le view de la modification du Ambassadeur
    public function edit(Ambassadeur $ambassadeur)
    {
        return view('ambassadeurs.edit', compact('ambassadeur'));
    }

    // Processus de modification du Ambassadeur
    public function update(Request $request, Ambassadeur $ambassadeur)
    {
        $request->validate([
            'id_utilisateur',
            'login',
            'mdp',
            'authentification_facebook',
            'cookies',
        ]);

        $ambassadeur->update($request->all());
        return redirect()->route('ambassadeurs')
            ->with('success', '');
    }

    // Procesuus de la suppression du Ambassadeur
    public function destroy(Ambassadeur $ambassadeur)
    {
        $ambassadeur->delete();
        return redirect()->route('ambassadeurs')
            ->with('success', '');
    }





    public function deleteAmbassadeur(Ambassadeur $ambassadeur, $id_ambassadeur)
    {

        $query = 'DELETE from ambassadeur_groupe
          WHERE ambassadeur_groupe.id_ambassadeur = ?';

        DB::delete($query, array($id_ambassadeur));
        //Ambassadeur::where('id_ambassadeur', $id_ambassadeur)->delete();

        return redirect()->route('deleteAmbassadeur', [$id_ambassadeur])
            ->with('success', '');
    }
    // // Direction view la liste groupe ambassadeur fichier groupamb

    public function groupeamb(Utilisateur $id_utilisateur, ambassadeurGroupe $ambassadeurGroupes, Ambassadeur $ambassadeur)
    {
        $ambassadeurGroupes = DB::table('groupes')
            ->leftjoin('ambassadeur_groupe', 'ambassadeur_groupe.id_groupe', '=', 'groupes.id_groupe')
            ->leftjoin('ambassadeurs', 'ambassadeur_groupe.id_ambassadeur', '=', 'ambassadeurs.id_ambassadeur')
            ->leftjoin('utilisateur', 'utilisateur.id_utilisateur', '=', 'ambassadeurs.id_ambassadeur')
            ->where('ambassadeurs.id_ambassadeur', 155)
            ->paginate(20);

        $ambassadeur = Ambassadeur::join('utilisateur', 'utilisateur.id_utilisateur', '=', 'ambassadeurs.id_ambassadeur')
            ->whereIn('id_utilisateur', $id_utilisateur)
            ->get(['ambassadeurs.*', 'utilisateur.Nom', 'utilisateur.prenom', 'utilisateur.id_utilisateur']);

        return view('ambassadeurs.groupeamb', compact('id_utilisateur', 'ambassadeur', 'ambassadeurGroupes'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
