<?php

namespace App\Repositories;
use App\User;
use App\Repositories\UsuariosRepositoryInterface;

class UsuariosRepositoryEloquent implements UsuariosRepositoryInterface{
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->orderby('id', 'desc')->get();
    }

    public function getUser($id)
    {
        return $user = $this->user->findOrFail($id);
    }

    public function create($data) 
    {
        return $user = $this->user->create($data);
    }

    public function updateUser($id)
    {
        $user = $this->user->findOrFail($id);
        return $user->update();
    }

    public function deleteUser($id)
    {
        $user = $this->user->findOrFail($id); 
        return $user->delete($id); 
    }
}