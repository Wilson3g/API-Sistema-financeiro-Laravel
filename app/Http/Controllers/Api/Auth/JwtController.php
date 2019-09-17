<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JwtController extends Controller
{
    public function login(Request $request)
    {
        // Recebe email e senha digitados
        $credentials = $request->all(['email', 'password']);

        // Confere se os dados são veridicos
        if(!$token = auth('api')->attempt($credentials)){
            return response()->json(['msg'=>'Não autorizado'], 401);
        }

        // Se autorizado, retorna o token para o usuário
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
