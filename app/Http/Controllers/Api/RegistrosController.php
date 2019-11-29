<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegistroRequest;
use App\Registro;
use App\Tag;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Response;
use DB;

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

        return response()->json([
            'message' => 'Registros!',
            'success' => true,
            'data' => $registros
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $registros = auth('api')->user()->registro()->findOrFail($id);

        return response()->json([
            'message' => 'Registros!',
            'success' => true,
            'data' => $registros
        ], Response::HTTP_OK);
    }

    public function store(RegistroRequest $request)
    {

        try{
            $data = $request->all();

            $data['user_id'] = auth('api')->user()->id;

            if(strtotime($request->input('data_vencimento')) < strtotime(Carbon::now()->toDateString()))
                return "data invalida";

            $registro = $this->registro->create($data);

            if(isset($data['tags']) && count($data['tags'])){
                $registro->tags()->sync($data['tags']);
            }

            return response()->json([
                'message' => 'Registro salvo com sucesso',
                'success' => true,
            ], Response::HTTP_OK);

        }catch(\Exception $e){
            return response()->json([
                'Ops, tivemos um problema... Erro: ' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, RegistroRequest $request)
    {

        if($this->registro->where('id', $id)->exists() == false)
            return response()->json([
                'message' => 'Registro não encontrado',
                'success' => false
            ], Response::HTTP_NOT_FOUND);

        $data = $request->all();

        $registros = auth('api')->user()->registro()->findOrFail($id);
        $registros->update($data);

        if(isset($data['tags']) && count($data['tags'])){
            $registros->tags()->sync($data['tags']);
        }

        return response()->json([
            'message' => 'Atualizado com sucesso',
            'success' => true
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
            
        $registro = auth('api')->user()->registro()->findOrFail($id);
        $registro->tags()->detach();
        $registro->delete($id); 
        
        return response()->json([
            'message' => 'Registro deletado com sucesso',
            'success' => true
        ], 200);

    }

    public function baixa($id)
    {
        $registro = $this->registro->findOrFail($id);

        $checkType =  strtoupper($registro->tipo);
        
        $checkType == 'C'  ? $registro->update(['status' => 1, 'tipo'=> 'R']) : $registro->update(['status' => 1, 'tipo'=> 'P']);

        return response()->json([
            'message' => 'Atualização registrada!',
            'success' => true
        ], Response::HTTP_OK);
    }

    public function searchForTags($id)
    {
//      Gostaria de explicar, mas nem eu entendi foi nada :)
        $registros = $this->registro->whereHas('tags', function($query) use ($id) {
            $query->where([
                ['tags.id', $id],
                ['user_id', auth('api')->user()->id]
            ]);
        })->select('descricao', 'data_vencimento', 'valor', 'tipo', 'status')->get();

        return response()->json([
            'message' => 'Registros!',
            'success' => true,
            'data' => $registros
        ]);
    }
}
