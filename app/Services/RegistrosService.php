<?php

namespace App\Services;

use App\Http\Requests\RegistroRequest;
use App\Registro;
use App\Repositories\RegistrosRepositoryInterface;
use App\Tag;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Response;
use DB;

class RegistrosService
{
    private $registro;

    public function __construct(RegistrosRepositoryInterface $registrosRepositoryInterface)
    {
        $this->registrosRepositoryInterface = $registrosRepositoryInterface;
    }

    public function index()
    {
        $registros = $this->registrosRepositoryInterface->all();

        return response()->json([
            'message' => 'Registros!',
            'success' => true,
            'data' => $registros
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $registros = $this->registrosRepositoryInterface->getRegistro($id);

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

            $registro = $this->registrosRepositoryInterface->create($data);

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
        // if($this->registro->where('id', $id)->exists() == false)
        //     return response()->json([
        //         'message' => 'Registro não encontrado',
        //         'success' => false
        //     ], Response::HTTP_NOT_FOUND);

        $data = $request->all();

        $registro = $this->registrosRepositoryInterface->updateRegistro($id, $data);

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
        $registro = $this->registrosRepositoryInterface->deleteRegistro($id);
        
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
        //Faz uma consulta usando as tabelas pivot
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
