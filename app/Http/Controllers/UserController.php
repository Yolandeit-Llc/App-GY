<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $data = User::latest()->paginate(20);

        return view('users.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'role',
            'id'

            ]);

        return redirect()->route('users.index')
                        ->with('success','');
    }


    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }


    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role',
            'password' => 'required'

        ]);

        $user->update($request->all());

        return redirect()->route('users.index')
                        ->with('success','');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success','');
    }

    public function deleteall(Request $request){
        $ids = $request->get('ids');
        User::whereIn('id',$ids)->delete();
        return redirect('users');
    }
    public function searchuser(Request $request)
    {
        $search = $request->get('search');
        $data= DB::table('users')->where('name','LIKE','%'.$search.'%')->paginate(5);
        return view('users.index',['users'=>$data]);
    }
}
