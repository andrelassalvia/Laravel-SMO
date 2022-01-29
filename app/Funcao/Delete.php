<?php

namespace App\Funcao;

use App\Models\Funcao;

class Delete
{
  public function __construct(Funcao $funcao){
    $this->funcao = $funcao;
  }
  
  public function erase(object $register){
    $deleteItem = $register->delete();
    
    return $deleteItem;
  }  
  
}