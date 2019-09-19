<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function registro()
    {
        return $this->belongsToMany(Registro::class, 'registros_has_tags');
    }

}
