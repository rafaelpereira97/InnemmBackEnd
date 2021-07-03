<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\GraphModel;
use App\Models\Corporationdetail;
use App\Models\Occurrence;
use App\Models\OccurrenceUser;
use App\Models\User;
use App\Models\Userlocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OccurrenceController extends Controller
{
    public function getOcurrences(Request $request){
        $ocurrences = $request->user()
            ->occurrences()->with("urgency", "userlocations")
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
            $occurrenceUser->estimated_arrivetime = $request->estimated_arrivetime;
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

    public function getUserInfo(Request $request){
        $user = User::with('groups')->find($request->user()->id);
        return response()->json($user,200);
    }


    public function getAverageArriveTime(Request $request){

        $user = User::find($request->user()->id);
        $tempos = array();

        foreach($user->occurrences as $occurrence){
            if(count($occurrence->userlocations) > 0){
                $primeiraLoc = $occurrence->userlocations()->where('user_id',$user->id)->first()->created_at;
                $segundaLoc = $occurrence->userlocations()->where('user_id',$user->id)->get()->last()->created_at;

                $totalDuration = $segundaLoc->diffInMinutes($primeiraLoc);

                array_push($tempos, $totalDuration);
            }
        }

        $tempoMedioChegada = collect($tempos)->avg();

        return response()->json(['tempo' => $tempoMedioChegada],200);

    }



    public function countAcceptedOccurrences(Request $request){
        $user = User::find($request->user()->id);

        $occurrences = Occurrence::join('occurrence_user', 'occurrence_user.occurrence_id', '=', 'occurrences.id')
            ->where('occurrence_user.status',1)
            ->where('occurrence_user.user_id',$user->id)
            ->get()->count();

        return response()->json(['aceites' => $occurrences]);
    }

    public function countRefusedOccurrences(Request $request){
        $user = User::find($request->user()->id);

        $occurrences = Occurrence::join('occurrence_user', 'occurrence_user.occurrence_id', '=', 'occurrences.id')
            ->where('occurrence_user.status',2)
            ->where('occurrence_user.user_id',$user->id)
            ->get()->count();

        return response()->json(['recusadas' => $occurrences]);
    }


    public function occurrencesAcceptedByMonth(Request $request){
        $user = User::find($request->user()->id);

        $months = ["01","02","03","04","05","06","07","08","09","10","11","12"];

        $array = array();

        foreach($months as $month){

            $graphModel = new GraphModel();

            $occurrencesAccepted = Occurrence::join('occurrence_user', 'occurrence_user.occurrence_id', '=', 'occurrences.id')
                ->selectRaw('COUNT(*) as accepted')
                ->where('occurrence_user.status',1)
                ->where('occurrence_user.user_id',$user->id)
                ->whereMonth('occurrence_user.updated_at', $month)
                ->get()->first()->accepted;

            $occurrencesRejected = Occurrence::join('occurrence_user', 'occurrence_user.occurrence_id', '=', 'occurrences.id')
                ->selectRaw('COUNT(*) as rejected')
                ->where('occurrence_user.status',2)
                ->where('occurrence_user.user_id',$user->id)
                ->whereMonth('occurrence_user.updated_at', $month)
                ->get()->first()->rejected;

            $graphModel->accepted = $occurrencesAccepted;
            $graphModel->rejected = $occurrencesRejected;

            array_push($array,$graphModel);

        }

        /*$occurrences = Occurrence::join('occurrence_user', 'occurrence_user.occurrence_id', '=', 'occurrences.id')
            ->selectRaw('COUNT(*), MONTH(occurrence_user.updated_at) as mes')
            ->where('occurrence_user.status',1)
            ->where('occurrence_user.user_id',$user->id)
            ->groupBy('mes')
            ->get();*/

        //dd($occurrences);

        return response()->json(['ocorrencias' => $array]);
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
