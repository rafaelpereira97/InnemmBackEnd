<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Corporationdetail;
use App\Models\Occurrence;
use App\Models\OccurrenceUser;
use App\Models\Userlocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OccurrenceController extends Controller
{
    public function getOcurrences(Request $request){
        $ocurrences = $request->user()
            ->occurrences()->where('status','!=',2)->with("urgency")
            ->get();
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

    public function acceptOccurrence(Request $request){

        try{
            $occurrenceUser = OccurrenceUser::where('occurrence_id',$request->occurrence_id)
                ->where('user_id',$request->user()->id)
                ->first();

            //ACCEPTED
            $occurrenceUser->status = 1;
            $occurrenceUser->save();

            return response()->json(null,200);

        }catch (\Exception $exception){
            return response()->json($exception->getMessage(),500);
        }

    }

    public function rejectOccurrence(Request $request){

        try{
            $occurrenceUser = OccurrenceUser::where('occurrence_id',$request->occurrence_id)
                ->where('user_id',$request->user()->id)
                ->first();

            //REJECTED
            $occurrenceUser->status = 2;
            $occurrenceUser->save();

            return response()->json(null,200);

        }catch (\Exception $exception){
            return response()->json($exception->getMessage(),500);
        }

    }

    public function updateOccurrenceUserLocation(Request $request){
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $occurrence_id = $request->occurrence_id;
        $user = $request->user();

        $user->latitude = $latitude;
        $user->longitude = $longitude;
        $user->save();

        $userLocation = new Userlocation();
        $userLocation->lat = $latitude;
        $userLocation->long = $longitude;
        $userLocation->user_id = $user->id;
        $userLocation->occurrence_id = $occurrence_id;
        $userLocation->save();

        $corporationDetails = Corporationdetail::first();

        $distance = $this->distance($corporationDetails->lat, $corporationDetails->long, $latitude, $longitude, "K");

        if($distance < 0.5){
            return response()->json(['result' => 'success', 'inRange' => true, 'debug' => $distance],200);
        }else{
            return response()->json(['result' => 'success', 'inRange' => false, 'debug' => $distance],200);
        }

    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}
