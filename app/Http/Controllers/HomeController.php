<?php

namespace App\Http\Controllers;

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
        $occurrences = Occurrence::all();
        $users = User::where('latitude','!=',null)
                ->where('longitude','!=',null)
                ->get();

        return view('home')
            ->with('occurrences',$occurrences)
            ->with('users',$users);

    }
}
