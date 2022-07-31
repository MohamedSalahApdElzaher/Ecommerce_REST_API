<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // POST
    public function Register(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
            return response()->json([
                'status' => 1,
                'msg' => 'user created successfully',
                'data' => [
                    'user' => $user
                ]
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status' => 0,
                'msg' => 'error '.$exception->getMessage(),
            ], 404);
        }
    }

    // POST
    public function Login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
            if(auth()->attempt($data)){
                $access_token = auth()->user()->createToken('accessToken')->accessToken;
                return response()->json([
                    'status' => 1,
                    'msg' => 'Logged in',
                    'data' => [
                        'user' => auth()->user(),
                        'token' => $access_token
                    ]
                ], 200);
            }else{
                return response()->json([
                    'status' => 0,
                    'msg' => 'something error'
                ], 404);
            }

    }
}
