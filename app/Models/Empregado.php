<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empregado extends Model
{
    use HasFactory;

    protected $table = 'empregado';
    public $timestamps = false;
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
    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function funcao()
    {
        return $this->belongsTo(Funcao::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
