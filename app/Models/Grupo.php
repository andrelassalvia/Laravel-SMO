<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Funcao;
use App\Models\Risco;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupo';
    protected $guarded = [];

    public $timestamps  = false;

    // public function funcoes()
    // {
    //     return $this->belongsToMany(Funcao::class);
    // }

    // public function riscos()
    // {
    //     return $this->belongsToMany(Risco::class);
    // }

   
}
