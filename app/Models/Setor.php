<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empregado;

class Setor extends Model
{
    use HasFactory;

    protected $table = 'setor';
    protected $fillable = [
        'nome',
                        
    ];
    public $timestamps = false;

}
