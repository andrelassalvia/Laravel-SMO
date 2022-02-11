<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAtendimento extends Model
{
    use HasFactory;

    protected $table = 'tipoatendimento';
    protected $fillable = [
        'nome',
    ];
    
    public $timestamps = false;

    public function grupoExame()
    {
        return $this->hasMany(GrupoExame::class);
    }
}
