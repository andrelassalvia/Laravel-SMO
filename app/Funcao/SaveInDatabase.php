<?php

namespace App\Funcao;

use App\Funcao\CheckDataBase;
use App\Funcao\CreateRegister;


class SaveInDatabase
{
  public function __construct(CheckDataBase $checkDataBase, CreateRegister $createRegister){
    $this->checkDataBase = $checkDataBase;
    $this->createRegister = $createRegister;
  }

  public function saveDatabase(string $data, string $columnToCheck)
  {
    
    $check = $this->checkDataBase->checkInDatabase($columnToCheck, $data);
    

    if($check == null){

      $insert = $this->createRegister->insert(['nome' => $data]);

      if($insert){
        return SuccessRedirectMessage::successRedirect('funcoes.index', ['success' => 'Registro cadastrado com sucesso' ]);
      }

    }
    else{
      return $check;
    }
  
  }

}
