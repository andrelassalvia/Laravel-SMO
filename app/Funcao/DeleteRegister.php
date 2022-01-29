<?php

namespace App\Funcao;

use App\Funcao\FindRegister;
use App\Models\Empregado;
use App\Funcao\Delete;


class DeleteRegister
{

  public function __construct(FindRegister $findRegister, Delete $delete)
  {
    $this->findRegister = $findRegister;
    $this->delete = $delete;
  }

  public function deleteRegisterInDatabase($id){

    $register = $this->findRegister->findId($id);
    
    $countEmployee = Empregado::where('funcao_id', $id)->get()->count();
    
    if($countEmployee > 0){
      
      return FailRedirectMessage::failRedirect('funcoes.show', ['errors' => 'Falha no delete. Existem  '.$countEmployee.' empregado(s) com esta função.']);
    }
    
    $deletedRegister = $this->delete->erase($register);
    

    if($deletedRegister){
      return SuccessRedirectMessage::successRedirect('funcoes.index', ['success' => 'Função deletada com sucesso.']);
    }
    else{
      return FailRedirectMessage::failRedirect('funcoes.show', ['errors' => 'Erro no delete']);
    }

  }


// deletar registro
// retornar msg
}