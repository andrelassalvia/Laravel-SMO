<?php

namespace App\Funcao;

use App\Models\Funcao;
use App\Funcao\CollectData;

class SearchRequest
{
  public function __construct(Funcao $funcao, CollectData $collectData)
  {
    $this->funcao = $funcao;
    $this->collectData = $collectData;
  }

  public function searchIt(string $targetColumn, $data){
    
    $wanted = $this->funcao->where($targetColumn, 'like', $data)->paginate(5);
    
    return $wanted;
  }

}