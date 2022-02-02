<?php

namespace App\AbstractClasses;


use Illuminate\Database\Eloquent\Model;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

abstract class DeleteRegister
{

  use FailRedirectMessage, SuccessRedirectMessage;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }
  
  public function erase(
    string $id, 
    array $linkedModels, 
    array $columnInModels, 
    string $routeError, 
    array $msgError,
    string $routeSuccess,
    array $msgSuccess
    )
    {
      $register = $this->model->find($id);


    for ($i=0; $i < count($linkedModels) ; $i++) { 
      
      $element = $linkedModels[$i];
            
      for ($j=0; $j <count($columnInModels) ; $j++) { 
       
        $colum = $columnInModels[$j];
        
        $countRegister = $element->where($colum, $id)->get()->count();
     
        if($countRegister > 0)
        {
          return FailRedirectMessage::failRedirect($routeError, $msgError, $id);
        }
      }
    }

    $deletedRegister = $register->delete();

    if($deletedRegister)
    {
      return SuccessRedirectMessage::successRedirect($routeSuccess, $msgSuccess);
    }
    else
    {
      return FailRedirectMessage::failRedirect($routeError, ['errors' => 'Falha no delete'], '');
    }

  }
}