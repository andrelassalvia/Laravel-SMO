<?php

namespace App\Classes\Funcao;

class DeleteRegister extends \App\AbstractClasses\DeleteRegister
{

// public static function deleteRegisterInDatabase($id){

//     $register = FindRegister::findId($id);
    
//     $countEmployee = Empregado::where('funcao_id', $id)->get()->count();
    
//     if($countEmployee > 0){
      
//       return FailRedirectMessage::failRedirect('funcoes.show', ['errors' => 'Falha no delete. Existem  '.$countEmployee.' empregado(s) com esta função.']);
//     }
    
//     $deletedRegister = Delete::erase($register);
    

//     if($deletedRegister){
//       return SuccessRedirectMessage::successRedirect('funcoes.index', ['success' => 'Função deletada com sucesso.']);
//     }
//     else{
//       return FailRedirectMessage::failRedirect('funcoes.show', ['errors' => 'Erro no delete']);
//     }

//   }


// deletar registro
// retornar msg
}