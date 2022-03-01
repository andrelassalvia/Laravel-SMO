<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model;

abstract class DeleteRegister
{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }
  
  public function erase(string $id) 
  {
    $register = $this->model->find($id);
    return $register->delete();
  }
}