<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;
use App\Models\Funcao;
use App\Models\Setor;

class GrupoFuncao extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'grupofuncao';

    protected $fillable = [
        'grupo_id',
        'funcao_id',
        'setor_id'
    ];

   public function grupo()
   {
       return $this->belongsTo(Grupo::class);
   }

   public function funcao()
   {
       return $this->belongsTo(Funcao::class);
   }

   public function setor()
   {
       return $this->belongsTo(Setor::class);
   }
}
