<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRisco extends Model
{
    use HasFactory;

    protected $table = 'tiporisco';
    protected $fillable = [
        'nome',
                        
    ];
}
