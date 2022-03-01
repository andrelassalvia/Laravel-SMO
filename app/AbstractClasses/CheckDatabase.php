<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model;

class CheckDataBase
{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function checkInDatabase(
    array $columns, // name of the columns to check in database
    array $values // columns values to form the combined array
  )
  {
    $combined = array_combine($columns, $values);
    
    $checkDatabase = $this->model->where($combined)->get()->first();

    if($checkDatabase == null){
      return $combined;
    } else {
      return null;
    }
  }
}