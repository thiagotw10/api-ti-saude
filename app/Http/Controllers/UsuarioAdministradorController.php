<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\UsuarioAdministrador;
use App\Http\Requests\UserValidation;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\AuthenticateValidation;
use Illuminate\Foundation\Auth\UserAdministrador;

class UsuarioAdministradorController extends Controller
{
    public function register(UserValidation $request)
    {

        //Request is valid, create new user
        $user = UsuarioAdministrador::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response($user, 201);
    }

    public function authenticate(AuthenticateValidation $request)
    {


        $credentials = $request->all();


        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }

 		//Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
