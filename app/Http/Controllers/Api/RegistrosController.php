<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegistroRequest;//importação do arquivo de validação
use App\Registro; // Importando o model Registro
use App\TagsController;
use App\Http\Controllers\Controller;

class RegistrosController extends Controller
{
    private $registro;

    // Injetando o model Registro
    public function __construct(Registro $registro)
    {
        $this->registro = $registro;
    }

    public function index()
    {
        // mosta todos os registros do usuario
        $registros = auth('api')->user()->registro;

        return response()->json($registros, 200);
    }

    public function show($id)
    {
        try{
            
            // envia a variavel com requests para a tabela
            $registros = auth('api')->user()->registro()->findOrFail($id);

            return response()->json([
                'data'=> [
                    'msg'=> 'Encontrado com sucesso!',
                    'data'=> $registros
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    public function store(RegistroRequest $request)
    {
        // Salva todos os requests em uma variavel
        $data = $request->all();

        // tratamento de erros
        try{
            
            $data['user_id'] = auth('api')->user()->id;

            // envia a variavel com requests para a tabela
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
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    public function update($id, RegistroRequest $request)
    {

        $data = $request->all();

        try{
            
            // envia a variavel com requests para a tabela
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

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    public function destroy($id)
    {
        try{
            
            $registro = auth('api')->user()->registro()->findOrFail($id); // envia a variável com requests para a tabela
            $registro->tags()->detach(); // apaga os registros da tabela pivot
            $registro->delete($id); // deleta o registro pelo id
            
            return response()->json([
                'data'=> [
                    'msg'=> 'Conta deletada com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    public function baixa($id, RegistroRequest $request)
    {
        try{
            
            $registro = $this->registro->findOrFail($id); // encontra o registro pelo id
            // $registro->update(['status' => 1, 'tipo'=> 'P']); // altera o campo status de 0 para 1

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

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }

    }
}
