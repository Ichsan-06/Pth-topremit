<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['user'=>$user,'token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['verify_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Password')->accessToken;

        $response= ['user' => $user];
        return response($response, 200);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function myprofile()
    {
        $user = Auth::user();

        return response($user, 200);
    }

    public function verifiedaccount(Request $request)
    {
        $user = Auth::user();

        $response = [
            'verify_token' => $user->verify_token
        ];

        return response($response, 200);
    }

    public function checkverifiedaccount(Request $request)
    {
        $user = User::where('verify_token',$request->input('token'))->first();

        if(!$user) {
            $response = [
                'message' => 'token is not valid'
            ];
            return response($response, 404);
        }

        if($user->account_verified_at !== null){
            $response = [
                'message' => 'Account has been active'
            ];
            return response($response, 403);
        }

        $response = [
            'message' => 'Account has been active'
        ];

        $user->account_verified_at = now();
        $user->save();

        return response($response, 200);
    }
}
