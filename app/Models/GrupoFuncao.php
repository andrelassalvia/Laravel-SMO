<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoFuncao extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'grupofuncao';

    protected $fillable = [
        'grupo_id',
        'funcao_id'
    ];

   
}
