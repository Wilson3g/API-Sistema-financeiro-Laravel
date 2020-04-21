<?php

namespace App\Repositories;

interface RegistrosRepositoryInterface {
    public function all();
    public function getRegistro($id);
}