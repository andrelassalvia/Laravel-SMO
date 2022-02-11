<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Risco;
use App\Models\Grupo;

class GrupoRisco extends Model
{
    use HasFactory;

    
    protected $table = 'gruporisco';
    protected $guarded = [];

    public $timestamps = false;

    public function risco()
    {
        return $this->belongsTo(Risco::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
