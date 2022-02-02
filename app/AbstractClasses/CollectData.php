<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model; 

abstract class CollectData
{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }


  public function collection(string $column, string $order){

   return $this->model->orderBy($column, $order)->paginate(5);

  }
}