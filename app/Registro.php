<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $fillable = [
        'user_id', 
        'descricao', 
        'data_vencimento', 
        'valor', 
        'tipo', 
        'status'
    ];

    public function user()
    {
        // Retorna a associação com base no objeto
        return $this->belongsTo(User::class); //Perternce ao objeto usuário
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'registros_has_tags');
    }
}
