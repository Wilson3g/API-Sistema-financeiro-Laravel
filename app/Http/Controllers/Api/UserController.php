<?php

namespace App\Http\Controllers\Api;

use App\User;// Importando o model de cadastro
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
        // mosta todos os dados em grupos de 10
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
            
            // envia a variavel com requests para a tabela
            $user = $this->user->findOrFail($id);

            return response()->json([
                'data'=> [
                    'msg'=> 'Usuário encontrado!',
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
        $data = $request->all();

        if($request->has('password') && $request->get('password')){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        try{
            
            // envia a variavel com requests para a tabela
            $user = $this->user->findOrFail($id);
            $user->update($data);

            return response()->json([
                'data'=> [
                    'msg'=> 'Usuário atualizado com sucesso!'
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
            
            $user = $this->user->findOrFail($id); // envia a variável com requests para a tabela
            $user->delete($id); // deleta o user pelo id

            return response()->json([
                'data'=> [
                    'msg'=> 'Usuário deletado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }
}
