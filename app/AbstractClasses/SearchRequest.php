<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model;

abstract class SearchRequest
{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function searchIt(
    string $column, // column name of the searched value
    array $data // 
  )
  {
    $register = $this->model->where($column, 'like', $data)->paginate(5);

    return $register;
  }
}