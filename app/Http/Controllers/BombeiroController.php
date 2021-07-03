<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BombeiroController extends Controller
{
    //

    public function index(){
        $users = User::all();
        return view('bombeiros.index')
            ->with('users',$users);
    }

    public function create(){
        $groups = Group::all();
        return view('bombeiros.create')
            ->with('groups',$groups);
    }

    public function store(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make(Str::random(13));
        $user->save();

        if($request->has('groups')){
            $user->groups()->sync($request->groups);
        }

        return redirect(route('bombeiro.index'));

    }

    public function delete(Request $request){
        $user = User::find($request->bombeiro_id);
        $user->delete();
        return redirect()->back();
    }

    public function edit(User $user){
        $groups = Group::all();
        return view('bombeiros.edit')
            ->with('user',$user)
            ->with('groups',$groups);
    }

    public function save(Request $request){
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if($request->has('groups')){
            $user->groups()->sync($request->groups);
        }

        return redirect(route('bombeiro.index'));
    }

}
