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
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'registros_has_tags');
    }
}
