<?php

namespace App\Funcao;

use App\Funcao\FindRegister;
use App\Funcao\CheckDataBase;
use App\Funcao\UpdateRegister;



class ChangeRegister
{

  public function __construct(FindRegister $findRegister, CheckDataBase $checkDatabase, UpdateRegister $updateRegister, SuccessRedirectMessage $successRedirectMessage)
  {
    $this->findRegister = $findRegister;
    $this->checkDatabase = $checkDatabase;
    $this->updateRegister = $updateRegister;
    $this->successRedirectMessage = $successRedirectMessage;

  }

  public function changeRegisterInDatabase($id, $columnToCheck, $data, $request){

    $register = $this->findRegister->findId($id);

    $check = $this->checkDatabase->checkInDatabase($columnToCheck, $data);

    if($check == null){

      $update = $this->updateRegister->newRegister($register, $request);

      if($update){
        return successRedirectMessage::successRedirect('funcoes.index', ['success' => 'Função alterada com sucesso']);
      }

    }
    else{
      return $check;
    }
  }
}