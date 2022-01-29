<?php

namespace App\Funcao;

use App\Models\Funcao;

class CheckDataBase
{
  public function __construct(Funcao $funcao){
    $this->funcao = $funcao;
  }

  public function checkInDatabase(string $column, string $data):?object{

    $funcao = $this->funcao->where($column, $data)->get()->first();
        
    // Erro se ja estiver cadastrada
    if($funcao != null){
        
        return FailRedirectMessage::failRedirect('funcoes.create', ['errors' => 'Funcao já cadastrada']);
        
    }
    
    else{
      
      return $funcao;
    }

  }
}