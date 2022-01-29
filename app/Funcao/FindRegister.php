<?php

namespace App\Funcao;

use App\Models\Funcao;

class FindRegister
{

  public function __construct(Funcao $funcao){
    $this->funcao = $funcao;
  }
  
  public function findId(string $id){

    return $this->funcao->find($id);
  }
}