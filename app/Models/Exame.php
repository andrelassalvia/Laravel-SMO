<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    use HasFactory;

    protected $table = 'exame';

    protected $fillable = [
        'nome',
        
    ];

    public $timestamps = false;

    public function grupoExame()
    {
        return $this->hasMany(GrupoExame::class);
    }

   

    

}
