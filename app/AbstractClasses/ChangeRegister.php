<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model;
use App\AbstractClasses\CheckDataBase;
use App\Traits\SuccessRedirectMessage;
use App\Traits\FailRedirectMessage;

abstract class ChangeRegister
{
  use SuccessRedirectMessage, FailRedirectMessage;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function changeRegisterInDatabase
  (
    string $id, 
    array $columnsToCheck,
    array $values, 
    string $routeSuccess, 
    array $msgSuccess, 
    string $routeError,
    array $msgError
    )
  {
    $register = $this->model->find($id);

    $checkDatabase = new CheckDatabase($this->model);
    $checkDatabase = $checkDatabase->checkInDatabase($columnsToCheck, $values);
   
    if($checkDatabase)
    {
    
      $update = $register->update($checkDatabase);

      if($update)
      {
        return SuccessRedirectMessage::successRedirect($routeSuccess, $msgSuccess, '');
      }
    }
    else
    {
      return FailRedirectMessage::failRedirect($routeError, $msgError, $id);
    }


  }
}