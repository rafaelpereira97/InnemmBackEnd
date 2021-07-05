<?php

namespace App\Http\Controllers;

use App\Models\Corporationdetail;
use App\Models\Occurrence;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $activeOccurrences = Occurrence::join('occurrence_user', 'occurrence_user.occurrence_id', '=', 'occurrences.id')
            ->where('occurrence_user.status',1)
            ->count();

        $doneOccurrences = Occurrence::join('occurrence_user', 'occurrence_user.occurrence_id', '=', 'occurrences.id')
            ->where('occurrence_user.status',2)
            ->count();

        $adminsCount = User::where('admin',1)->count();

        $bombeirosCount = User::where('admin',0)->count();

        $occurrences = Occurrence::where('status',1)->get();
        $occurrencesDone = Occurrence::where('status',0)->get();

        $users = User::where('latitude','!=',null)
                ->where('longitude','!=',null)
                ->get();

        $corporation = Corporationdetail::first();

        return view('home')
            ->with('occurrences',$occurrences)
            ->with('users',$users)
            ->with('activeOccurrences',$activeOccurrences)
            ->with('doneOccurrences',$doneOccurrences)
            ->with('adminsCount',$adminsCount)
            ->with('bombeirosCount',$bombeirosCount)
            ->with('occurrencesDone',$occurrencesDone)
            ->with('corporation',$corporation);

    }
}
