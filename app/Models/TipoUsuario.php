<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipousuario';
    protected $fillable = [
        'nome',
                        
    ];
    public $timestamps = false;

    public function users(){
        return $this->hasMany(User::class);
    }

    public function permissoes(){
        return $this->hasMany(Permissao::class);
    }
}


