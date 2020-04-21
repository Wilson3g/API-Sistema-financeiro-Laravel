<?php

namespace App\Http\Controllers\Api;

use App\User; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Services\UsuarioService;

class UserController extends Controller
{

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index()
    {
        $this->usuarioService->index();
    }

    public function store(Request $request)
    {
        return $this->usuarioService->store($request);
    }

    public function show($id)
    {
        return $this->usuarioService->show($id);

    }

    public function update(Request $request, $id)
    {
        return $this->usuarioService->update($request, $id);
    }

    public function upadatePassword(Request $request)
    {
        // Criar método
    }

    public function destroy($id)
    {
        return $this->usuarioService->destroy($id);
    }
}
