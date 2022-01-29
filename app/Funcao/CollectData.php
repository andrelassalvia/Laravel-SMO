<?php

namespace App\Funcao;

use App\Models\Funcao;

class CollectData
{
  public function __construct(Funcao $funcao){
    $this->funcao = $funcao;
  }

  public function collection(string $column, string $order){

    return $this->funcao->orderBy($column, $order)->paginate(5);

  }
}