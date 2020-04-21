<?php

namespace App\Repositories;
use App\User;

class UsuariosRepositoryEloquent {
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }
}