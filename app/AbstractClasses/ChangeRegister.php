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
    int $id, 
    $columnToCheck,
    $data, 
    $routeSuccess, 
    $msgSuccess, 
    $routeError,
    $msgError
    )
  {
    $register = $this->model->find($id);

    $checkDatabase = new CheckDatabase($this->model);
    $checkDatabase = $checkDatabase->checkInDatabase($columnToCheck, $data);

    if($checkDatabase == null)
    {
      $update = $register->update($data);

      if($update)
      {
        return SuccessRedirectMessage::successRedirect($routeSuccess, $msgSuccess);
      }
    }
    else
    {
      return FailRedirectMessage::failRedirect($routeError, $msgError, $id);
    }


  }
}