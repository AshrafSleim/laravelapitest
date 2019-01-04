<?php

namespace App\Http\Controllers;

use App\User;
use Dotenv\Validator;
use http\Env\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTFactory;
use JWTAuth;


class APIRegister extends Controller
{
    public function register(Request $request){

        $validator =\Validator::make($request->all(),[
            'email'=>'required | email | max:255 | unique:users',
            'name'=>'required',
            'password'=>'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors());
        }else{
            User::create([
                'name'=>$request->get('name'),
                'email'=>$request->get('email'),
                'password'=>bcrypt($request->get('password'))
            ]);
            $user=User::first();
            $token=JWTAuth::fromUser($user);
            return response()->json(compact('token'));
        }
    }
}
