<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GrupoExame extends Model
{
    use HasFactory;

    protected $table = 'grupoexame';

    protected $fillable = [
        'grupo_id',
        'exame_id',
        'tipoatendimento_id',
        
        
        
    ];

    public function countInDataBase($key, $id){

        $search = $this->where($key,$id)->get()->count();
        
        // Erro se ja estiver cadastrada
        if($search > 0){
            $msg = ['errors' => 'Falha no Delete. Existem '. $search. ' :attribute ligados a este exame.'];
            return $this->failRedirect('exames.show', $msg);
        }
    }
}
