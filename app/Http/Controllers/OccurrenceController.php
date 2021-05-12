<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Occurrence;
use App\Models\Urgency;
use Illuminate\Http\Request;

class OccurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $urgencies = Urgency::all();
        $groups = Group::all();

        return view('occurrences.index')
            ->with('urgencies',$urgencies)
            ->with('groups',$groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $occurrence = new Occurrence();
        $occurrence->title = $request->occurrence;
        $occurrence->description = $request->desc_occurrence;
        $occurrence->urgency_id = $request->urgency_id;
        $occurrence->save();

        $group = Group::find($request->group_id);
        foreach($group->users as $user){
            $occurrence->users()->attach($user->id);
            \OneSignal::sendNotificationToUser(
                "Tem uma nova Ocorrência por favor verifique na aplicação!",
                $user->playerID,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null
            );
        }

        return redirect(route("home"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
