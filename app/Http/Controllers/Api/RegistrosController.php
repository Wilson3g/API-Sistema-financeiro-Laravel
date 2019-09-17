<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegistroRequest;//importação do arquivo de validação
use App\Registro; // Importando o model Registro
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
        // mosta todos os dados em ordem decrescente
        $registro = $this->registro->orderby('id', 'desc')->get();

        return response()->json($registro, 200);
    }

    public function show($id)
    {
        try{
            
            // envia a variavel com requests para a tabela
            $registro = $this->registro->findOrFail($id);

            return response()->json([
                'data'=> [
                    'msg'=> 'Conta atualizada com sucesso!',
                    'data'=> $registro
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
            $registro = $this->registro->findOrFail($id);
            $registro->update($data);

            if(isset($data['tags']) && count($data['tags'])){
                $registro->tags()->sync($data['tags']);
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
            
            $registro = $this->registro->findOrFail($id); // envia a variável com requests para a tabela
            $registro->delete($id); // deleta o registro pelo id
            $registro->tags()->detach(); // apaga os registros da tabela pivot

            return response()->json([
                'data'=> [
                    'msg'=> 'Conta deletada com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    public function pay($id, Request $request)
    {
        try{
            
            $registro = $this->registro->findOrFail($id); // encontra o registro pelo id
            $registro->update(['status' => 1, 'tipo'=> 'P']); // altera o campo status de 0 para 1

            return response()->json([
                'data'=> [
                    'msg'=> 'Conta atualizada com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }

    }

    public function receive($id, Request $request)
    {
        try{
            
            $registro = $this->registro->findOrFail($id); // encontra o registro pelo id
            $registro->update(['status' => 1, 'tipo'=> 'R']); // altera o campo status de 0 para 1

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
