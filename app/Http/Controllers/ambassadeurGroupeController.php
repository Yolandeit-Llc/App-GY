<?php

namespace App\Http\Controllers;

use App\Models\Ambassadeur;
use Illuminate\Support\Facades\DB;
use App\Models\ambassadeurGroupe;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class ambassadeurGroupeController extends Controller
{
    public function index(Utilisateur $id_utilisateur,  ambassadeurGroupe $ambassadeurGroupes, Ambassadeur $ambassadeurs)
    {

          $ambassadeurGroupes = DB::table('groupes')
            ->leftjoin('ambassadeur_groupe', 'ambassadeur_groupe.id_groupe', '=', 'groupes.id_groupe')
            ->leftjoin('ambassadeurs','ambassadeur_groupe.id_ambassadeur', '=', 'ambassadeurs.id_ambassadeur')
            ->leftjoin('utilisateur','utilisateur.id_utilisateur','=','ambassadeurs.id_ambassadeur')
            ->where('ambassadeurs.id_ambassadeur')

            ->paginate(20);

        $ambassadeurs = Ambassadeur::join('utilisateur','utilisateur.id_utilisateur', '=', 'ambassadeurs.id_ambassadeur')
            ->whereIn('id_utilisateur', $id_utilisateur)
            ->get(['ambassadeurs.*', 'utilisateur.nom', 'utilisateur.prenom', 'utilisateur.id_utilisateur']);



        return view('AmbassadeurGroupe.index', compact('ambassadeurGroupes', 'id_utilisateur', 'ambassadeurs'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function destroy(ambassadeurGroupe $ambassadeurGroupes)
    {
        $ambassadeurGroupes->delete();
        return redirect()->route('AmbassadeurGroupe')
            ->with('success', '');
    }
    public function create()
    {
        return view('AmbassadeurGroupe.create');
    }

    // Processus de creation
    public function store(Request $request)
    {
        $request->validate([
            'id_ambassadeur',
            'statut_adhesion',
            'id_groupe',
            'date_adhesion',
            'notifications',
            'traitement',
            'statut_releve',
            'releve_100_posts',
            'nb_posts_releves_analyse'
        ]);

        ambassadeurGroupe::create($request->all());

        return redirect()->route('AmbassadeurGroupe')
            ->with('success', '');
    }
    public function show(ambassadeurGroupe $ambassadeurGroupes)
    {
        $ambassadeurGroupes->with('ambassadeur_groupe')->get();
        return view('AmbassadeurGroupe.show', compact('ambassadeurGroupes'));
    }
    public function edit(ambassadeurGroupe $ambassadeurGroupes)
    {
        return view('AmbassadeurGroupe.edit', compact('ambassadeurGroupes'));
    }

    // Processus de modification du Ambassadeur
    public function update(Request $request, ambassadeurGroupe $ambassadeurGroupes)
    {
        $request->validate([
            'id_ambassadeur',
            'statut_adhesion',
            'id_groupe',
            'date_adhesion',
            'notifications',
            'traitement',
            'statut_releve',
            'releve_100_posts',
            'nb_posts_releves_analyse'
        ]);

        $ambassadeurGroupes->update($request->all());
        return redirect()->route('AmbassadeurGroupe')
            ->with('success', '');
    }
}
