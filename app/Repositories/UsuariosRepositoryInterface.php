<?php

namespace App\Repositories;

interface UsuariosRepositoryInterface {
    public function all();
    public function getUser($id);
    public function create($data);
    public function updateUser($id);
    public function deleteUser($id);
}