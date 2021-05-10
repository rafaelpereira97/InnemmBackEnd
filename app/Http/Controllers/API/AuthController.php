<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request){

        $user = User::where('email', $request->email)->first();

        if($user){
            if(Hash::check($request->password,$user->password)){

                $api_token = Str::random(60);
                $user->api_token = $api_token;
                $user->playerID = $request->playerID ?? null;
                $user->save();

                return response()->json([
                    'status' => 'success',
                    'token' => $user->api_token
                    ],200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'token' => null
                ],401);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'token' => null
            ],401);
        }
    }

    public function attachPlayerIDtoLoggedUser(Request $request){
            $user = $request->user();
            $user->playerID = $request->playerID;
            $user->save();
            return response()->json(null,200);
    }

    public function saveLastPosition(Request $request){
        $user = $request->user();
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();
        return response()->json(null,200);
    }

}
