<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empregado extends Model
{
    use HasFactory;

    protected $table = 'empregado';
    protected $fillable = [
        'nome',
        'cpf',
        'ctps',
        'serie',
        'data_nascimento',
        'data_admissao',
        'data_demissao',
        'setor_id',
        'funcao_id',
        'grupo_id',
        
    ];
}
