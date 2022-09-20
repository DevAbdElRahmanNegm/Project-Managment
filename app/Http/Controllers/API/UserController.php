<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
class UserController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function empolyee(Request $request){

      $user = User::create([
         'name'=>$request->name,
         'email'=>$request->email,
         'password'=> Hash::make($request->password),
          'is_admin'=> false,
        ]);
    $token = $user->createToken('Token')->accessToken;
    return response()->json(['token'=>$token,'user'=>$user],200);
    }

}
