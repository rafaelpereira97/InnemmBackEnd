<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Occurrence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OccurrenceController extends Controller
{
    public function getOcurrences(Request $request){
        $ocurrences = $request->user()
            ->occurrences()->with("urgency")
            ->get();
        return response()->json($ocurrences);
    }
}
