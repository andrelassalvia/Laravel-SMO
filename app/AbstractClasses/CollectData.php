<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model; 

abstract class CollectData
{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function collection(
    string $column, // column name to sort
    string $order, // ascending or descending
    string $list // if the collection is a dropdown list pass True to scape pagination
  )
  {
    if($list){
      return $this->model->orderBy($column, $order)->get();
    } else {
        return $this->model->orderBy($column, $order)->paginate(5);
    }
  }
}