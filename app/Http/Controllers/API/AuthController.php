<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userlogin(Request $request){

        $data = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if (\auth()->attempt($data)){
            $token = \auth()->user()->createToken('Token')->accessToken;
            return response()->json(['token'=>$token],200);
        }else{
            return response()->json(['error'=>'UnAuthrized'],401);
        }

    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        Auth::user()->token()->revoke();
        return response()->json(['User Loged Out'],200);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(){

        $user = \auth()->user();

        return response()->json(['data'=>$user],200);
    }
}
