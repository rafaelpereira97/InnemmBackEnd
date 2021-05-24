<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Occurrence;
use App\Models\OccurrenceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OccurrenceController extends Controller
{
    public function getOcurrences(Request $request){
        $ocurrences = $request->user()
            ->occurrences()->with("urgency")
            ->get();
        dd($ocurrences);
        return response()->json($ocurrences);
    }

    public function occurrenceOpened(Request $request){

        try{
            $occurrenceUser = OccurrenceUser::where('occurrence_id',$request->occurrence_id)
                ->where('user_id',$request->user()->id)
                ->first();

            $occurrenceUser->opened = 1;
            $occurrenceUser->save();

            return response()->json(null,200);

        }catch (\Exception $exception){
            return response()->json($exception->getMessage(),500);
        }

    }

}
