<?php

namespace App\Http\Controllers;

use App\Models\Corporationdetail;
use App\Models\Group;
use App\Models\Message;
use App\Models\Occurrence;
use App\Models\OccurrenceUser;
use App\Models\Urgency;
use App\Models\User;
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
        $messages = Message::all();
        $corporation = Corporationdetail::first();

        return view('occurrences.index')
            ->with('urgencies',$urgencies)
            ->with('groups',$groups)
            ->with('messages',$messages)
            ->with('corporation',$corporation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $coords = explode(",", $request->coordinates);
        $latitude = $coords[0];
        $longitude = $coords[1];

        $occurrence = new Occurrence();
        $occurrence->title = $request->occurrence;
        $occurrence->description = $request->desc_occurrence;
        $occurrence->urgency_id = $request->urgency_id;
        $occurrence->latitude = $latitude;
        $occurrence->longitude = $longitude;
        $occurrence->save();

        $group = Group::find($request->group_id);

        foreach($group->users as $user){
            $occurrence->users()->attach($user->id);
            if($user->playerID != null){
                \OneSignal::sendNotificationToUser(
                    "Tem uma nova Ocorrência por favor verifique na aplicação!",
                    $user->playerID,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null
                );
            }
        }

        return redirect(route("home"));
    }

    public function getAutoMessages(Group $group){
        $messages = $group->messages;
        return response()->json($messages);
    }


    public function show(Occurrence $occurrence)
    {
        $users = $occurrence->users()->withPivot('opened','status')->get();
        $corporation = Corporationdetail::first();
        return view('occurrences.show')
            ->with('users',$users)
            ->with('occurrence',$occurrence)
            ->with('corporation',$corporation);
    }


    public function getUserLocations(User $user, Occurrence $occurrence){
        $positions = $user->getLocationsByOccurrence($occurrence);
        $positionsJson = array();

        foreach($positions as $position){
            array_push($positionsJson,[(float)$position->long,(float)$position->lat]);
        }

        return response()->json($positionsJson,200);
    }


    public function rejectUser(User $user, Occurrence $occurrence){
        try{
            OccurrenceUser::where('user_id',$user->id)->where('occurrence_id',$occurrence->id)->first()->delete();

            \OneSignal::sendNotificationToUser(
                "O Quartel informa que não necessita da sua presença na ocorrência !",
                $user->playerID,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null
            );

        }catch (\Exception $exception){
            return redirect()->back();
        }

        return redirect()->back();
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
