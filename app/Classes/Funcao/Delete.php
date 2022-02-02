<?php

namespace App\Funcao;

class Delete
{
  
  
  public static function erase(object $register){
    $deleteItem = $register->delete();
    
    return $deleteItem;
  }  
  
}