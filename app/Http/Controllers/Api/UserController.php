<?php

namespace App\Http\Controllers\Api;


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
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password')){
            return response()->json(['msg' => 'É necessário informar uma senha!']);
        }

        try{
            $data['password'] = bcrypt($data['password']);
            
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
        $user = $this->user->findOrFail($id);

        return response()->json([
            'data'=> [
                'msg'=> 'Perfil encontrado!',
                'data'=> $user
            ]
        ], 200);

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


        $user = $this->user->findOrFail($id);

        $user->update($data);

        return response()->json([
            'data'=> [
                'msg'=> 'Perfil atualizado com sucesso!'
            ]
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = $this->user->findOrFail($id); 

        $user->delete($id); 

        return response()->json([
            'data'=> [
                'msg'=> 'Perfil deletado com sucesso!'
            ]
        ], 200);

    }
}
