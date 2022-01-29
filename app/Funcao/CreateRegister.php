<?php

namespace App\Funcao;

use App\Models\Funcao;

class CreateRegister
{

  public function __construct(Funcao $funcao){
    $this->funcao = $funcao;
  }

  public function insert(array $data){
    
    return $this->funcao->create($data);
  }

}