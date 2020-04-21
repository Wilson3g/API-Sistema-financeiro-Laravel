<?php

namespace App\Repositories;
use App\Registro;
use App\Repositories\RegistrosRepositoryInterface;

class RegistrosRepositoryEloquent implements RegistrosRepositoryInterface{
    
    public function __construct(Registro $registro)
    {
        $this->registro = $registro;
    }

    public function all()
    {
        return $this->registro->orderby('id', 'desc')->get();
    }

    public function getRegistro($id)
    {
        return  $registros = auth('api')->user()->registro()->findOrFail($id);
    }

    public function create($data) 
    {
        return $this->registro->create($data);
    }

    public function updateRegistro($id, $data)
    {
        $registros = auth('api')->user()->registro()->findOrFail($id);
        return $registros->update($data);
    }

    public function deleteRegistro($id)
    {
        $registro = auth('api')->user()->registro()->findOrFail($id);
        $registro->tags()->detach();
        return $registro->delete($id); 
    }
}