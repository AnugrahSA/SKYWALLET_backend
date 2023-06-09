<?php

namespace App\Http\Controllers\AuthApi;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Helpers\Validation;

class Commands extends Controller
{
    public function login(Request $request)
    {
        $validator = Validation::getValidateLogin($request);

        if($validator->fails()){
            $errors = $validator->messages();

            return response()->json([
                'status' => 'failed',
                'result' => $errors,
                'token' => null,
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        } else{
            $user = User::where('email', $request->email)->first();
            if(!$user || ($request->password != $user->password)){
                // throw ValidationException::withMessages([
                //     'result' => ['The provided credentials are incorrect.'],
                // ]);
                return response()->json([
                    'status' => 'failed',
                    'result' => 'Email or password incorrect',
                    'token' => null,
                ], Response::HTTP_UNAUTHORIZED);
            } else{
                $token = $user->createToken('login')->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'result' => $user,
                    'token' => $token,
                ], Response::HTTP_OK);
            }
        }
    }
}