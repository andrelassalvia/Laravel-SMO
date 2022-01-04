<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    use HasFactory;
    protected $table = 'atendimento';
    protected $fillable =[
        'data_atendimento',
        'trabalhoaltura',
        'espacoconfinado',
        'apto',
        'coordenador_id',
        'empregado_id',
        'setor_id',
        'funcao_id',
        'grupo_id',
        'tipoatendimento_id'

    ];
}
