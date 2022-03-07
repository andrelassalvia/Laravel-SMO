<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model; 

abstract Class SaveInDatabase
{  
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function saveDatabase(array $data)
  {
    return $this->model->create($data);
  }
}