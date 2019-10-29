<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegistroRequest;
use App\Registro; 
use App\TagsController;
use App\Http\Controllers\Controller;

class RegistrosController extends Controller
{
    private $registro;

    public function __construct(Registro $registro)
    {
        $this->registro = $registro;
    }

    public function index()
    {

        $registros = auth('api')->user()->registro;

        return response()->json($registros, 200);
    }

    public function show($id)
    {
        $registros = auth('api')->user()->registro()->findOrFail($id);

        return response()->json([
            'data'=> [
                'msg'=> 'Encontrado com sucesso!',
                'data'=> $registros
            ]
        ], 200);
    }

    public function store(RegistroRequest $request)
    {
        $data = $request->all();

        try{
            
            $data['user_id'] = auth('api')->user()->id;

            $registro = $this->registro->create($data);

            if(isset($data['tags']) && count($data['tags'])){
                $registro->tags()->sync($data['tags']);
            }

            return response()->json([
                'data'=> [
                    'msg'=> 'Conta registrada com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['Tag inexistente (cadastre ou selecione outra tag) Erro: ' => $e->getMessage()], 401);
        }
    }

    public function update($id, RegistroRequest $request)
    {

        $data = $request->all();

        $registros = auth('api')->user()->registro()->findOrFail($id);
        $registros->update($data);

        if(isset($data['tags']) && count($data['tags'])){
            $registros->tags()->sync($data['tags']);
        }

        return response()->json([
            'data'=> [
                'msg'=> 'Conta atualizada com sucesso!'
            ]
        ], 200);
    }

    public function destroy($id)
    {
            
        $registro = auth('api')->user()->registro()->findOrFail($id);
        $registro->tags()->detach();
        $registro->delete($id); 
        
        return response()->json([
            'data'=> [
                'msg'=> 'Conta deletada com sucesso!'
            ]
        ], 200);

    }

    public function baixa($id, RegistroRequest $request)
    {
            
        $registro = $this->registro->findOrFail($id); 
        
        if($registro->tipo == 'C'){
            $registro->update(['status' => 1, 'tipo'=> 'R']);
        }else{
            $registro->update(['status' => 1, 'tipo'=> 'P']);
        }

        return response()->json([
            'data'=> [
                'msg'=> 'Conta atualizada com sucesso!'
            ]
        ], 200);

    }
}
