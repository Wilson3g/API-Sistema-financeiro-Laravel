<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JwtController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        if(!$token = auth('api')->attempt($credentials)){
            return response()->json(['msg'=>'Usuário ou senha inválidos!'], 401);
        }

        return response()->json([
            'token'=> $token
        ]);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['msg'=> 'Logout feito com sucesso!'], 200);
    }
}
