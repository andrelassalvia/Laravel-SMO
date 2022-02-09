<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model; 
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;
use App\AbstractClasses\CheckDataBase;

abstract Class SaveInDatabase
{
  use FailRedirectMessage;
  use SuccessRedirectMessage;
 
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function saveDatabase
  (
    array $column,
    array $data,
    string $routeSuccess, 
    array $msgSuccess, 
    string $routeError, 
    array $msgError,
    string $id
  )

  {
    $checkDatabase = new CheckDataBase($this->model);
    $checkDatabase = $checkDatabase->checkInDatabase($column, $data);
        
    // Erro se ja estiver cadastrada
    if($checkDatabase == null){
        
        return FailRedirectMessage::failRedirect($routeError, $msgError, $id);
        
    }
    
    else{

       $this->model->create($checkDatabase);

       return SuccessRedirectMessage::successRedirect($routeSuccess, $msgSuccess, $id);
      }

  }
}