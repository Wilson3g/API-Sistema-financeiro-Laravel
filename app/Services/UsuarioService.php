<?php

namespace App\Services;

use App\User; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UsuariosRepositoryInterface;
use Illuminate\Http\Response;
 
class UsuarioService
{
    public function __construct(User $user, UsuariosRepositoryInterface $usuariosRepository)
    {
        $this->user = $user;
        $this->usuariosRepository = $usuariosRepository;
    }

    public function index()
    {
        $user = $this->usuariosRepository->all();

        return response()->json([
            'message' => 'Todos os perfis',
            'success' => true,
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function store($request)
    {
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password')){
            return response()->json(['msg' => 'É necessário informar uma senha!']);
        }

        try{
            $data['password'] = bcrypt($data['password']);
            
            $user = $this->usuariosRepository->create($data);

            return response()->json([
                'data'=> [
                    'msg'=> 'Cadastro realizado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    public function show($id)
    {
        $user = $this->usuariosRepository->getUser($id);

        return response()->json([
            'message' => 'Usuário encontrado',
            'success' => true,
            'data' => $user
        ], Response::HTTP_OK);

    }

    public function update($request, $id)
    {
        if($this->user->where('id', $id)->exists() == false)
            return response()->json([
                'message' => 'Usuário inválido',
                'success' => false
            ], Response::HTTP_NOT_FOUND);

        $user = $this->usuariosRepository->updateUser($id);

        return response()->json([
                'message'=> 'Perfil atualizado com sucesso!',
                'success' => true,
        ], Response::HTTP_OK);

    }

    public function upadatePassword(Request $request)
    {
        // Criar método
    }

    public function destroy($id)
    {
        $user = $this->usuariosRepository->deleteUser($id);

        return response()->json([
            'message' => 'Perfil deletado com sucesso!',
            'success' => true
        ], Response::HTTP_OK);

    }
}
