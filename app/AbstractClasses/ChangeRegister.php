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

  public function changeRegisterInDatabase(
    string $id, 
    array $columnsToCheck, // columns within this model to check if it's unique
    array $values, // data to check if it's unique
    string $routeSuccess, // route case success
    array $msgSuccess, // return message case success
    string $routeError, // route case error
    array $msgError // return message case error
    ) {
        $register = $this->model->find($id);

        $checkDatabase = new CheckDatabase($this->model);
        $checkDatabase = $checkDatabase->checkInDatabase($columnsToCheck, $values);
      
        if($checkDatabase){
          $update = $register->update($checkDatabase);
          if($update){
            return SuccessRedirectMessage::successRedirect(
              $routeSuccess, 
              $msgSuccess, 
              ''
            );
          }
        } else {
          return FailRedirectMessage::failRedirect($routeError, $msgError, $id);
        }
      }
}