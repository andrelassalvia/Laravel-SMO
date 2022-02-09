<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoRisco;

class Risco extends Model
{
    use HasFactory;

    protected $table = 'risco';
    protected $fillable = [
        'nome',
        'tiporisco_id',
                
    ];

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class);
    }

    public function tiporisco(){
        return $this->belongsTo(TipoRisco::class);
    }
}
