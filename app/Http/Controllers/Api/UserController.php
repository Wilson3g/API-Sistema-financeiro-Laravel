<?php

namespace App\Http\Controllers\Api;

// Definindo o model de User
use App\User; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // mosta todos os dados em ordem decrescente
        $user = $this->user->orderby('id', 'desc')->get();
        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Salva todos os requests em uma variavel
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password')){
            return response()->json(['msg' => 'É necessário informar uma senha!']);
        }

        // tratamento de erros
        try{

            // Encripta a senha digitada
            $data['password'] = bcrypt($data['password']);
            
            // envia a variavel com requests para a tabela
            $user = $this->user->create($data);

            return response()->json([
                'data'=> [
                    'msg'=> 'Usuário cadastrado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            
            // Busca os dados na tabela pelo id do usuário
            $user = $this->user->findOrFail($id);

            return response()->json([
                'data'=> [
                    'msg'=> 'Perfil encontrado!',
                    'data'=> $user
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Salva todos os requests em uma variavel
        $data = $request->all();

        // Verifica se o usuário informou uma senha
        if($request->has('password') && $request->get('password')){
            // Encripta a senha informada
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        try{
            
            // envia a variavel com requests para a tabela
            $user = $this->user->findOrFail($id);
            // atualiza o usuário pelo id
            $user->update($data);

            return response()->json([
                'data'=> [
                    'msg'=> 'Perfil atualizado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            // envia a variável com requests para a tabela
            $user = $this->user->findOrFail($id); 
            // deleta o user pelo id
            $user->delete($id); 

            return response()->json([
                'data'=> [
                    'msg'=> 'Perfil deletado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }
}
