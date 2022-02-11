<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Funcao extends Model
{
    use HasFactory;
   
    protected $table = 'funcao';

    protected $fillable = [
        'nome',
    ];

    public $timestamps = false;

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class);
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function grupoFuncoes()
    {
        return $this->hasMany(GrupoFuncao::class);
    }

}
