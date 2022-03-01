<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model;

abstract class ChangeRegister
{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function changeRegisterInDatabase(
    string $id,  // old register id
    array $data // new data to be updated
  ) 
  {
    $register = $this->model->find($id);
    $update = $register->update($data);
    
    return $update;
  }
}