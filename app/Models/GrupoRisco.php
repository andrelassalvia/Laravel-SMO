<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoRisco extends Model
{
    use HasFactory;

    
    protected $table = 'gruporisco';
    protected $fillable = [
        'grupo_id',
        'risco_id',
        
        
        
        
    ];
}
