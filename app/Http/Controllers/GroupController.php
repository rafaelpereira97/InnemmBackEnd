<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        return view('groups.index')
            ->with('groups',$groups);
    }


    public function create()
    {
        $bombeiros = User::all();

        return view('groups.create')
            ->with('bombeiros',$bombeiros);
    }

    public function store(Request $request)
    {
        $group = new Group();
        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();

        $group->users()->sync($request->bombeiros);

        return redirect(route('group.index'));
    }

    public function show(Group $group)
    {
        $bombeiros = User::all();

        return view('groups.edit')
            ->with('group',$group)
            ->with('bombeiros',$bombeiros);
    }

    public function edit(Request $request, Group $group)
    {
        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();

        $group->users()->sync($request->bombeiros);

        return redirect(route('group.index'));
    }

    public function delete(Request $request){
        $group = Group::find($request->group_id);
        $group->delete();
        return redirect(route('group.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
