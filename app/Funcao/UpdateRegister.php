<?php

namespace App\Funcao;

use App\Models\Funcao;

class UpdateRegister 
{
  public function __construct(Funcao $funcao){
    $this->funcao = $funcao;
  }
  
  public function newRegister(object $register, array $request)
  {
    return $register->update($request);
  }
}
