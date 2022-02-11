<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;
use App\Models\Exame;
use App\Models\TipoAtendimento;


class GrupoExame extends Model
{
    use HasFactory;

    protected $table = 'grupoexame';

    protected $fillable = [
        'grupo_id',
        'exame_id',
        'tipoatendimento_id',
        
    ];

    public $timestamps = false;

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function exame()
    {
        return $this->belongsTo(Exame::class);
    }

    public function tipoatendimento()
    {
        return $this->belongsTo(TipoAtendimento::class);
    }

   
}
