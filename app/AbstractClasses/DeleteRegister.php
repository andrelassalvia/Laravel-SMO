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
    string $id, // id do model instanciado
    array $linkedModels, // array com todas os models vinculados a este
    array $columnInModels, // nome da coluna da chave estangeira
    string $routeError, // rota de retorno em caso de erro
    string $routeSuccess, // rota de retorno em caso de sucesso no delete
    array $msgSuccess, // mensagem de retorno em caso de sucesso no delete
    string $mainId // id do model pai (se houver)
    )
    {
      $register = $this->model->find($id);
      
      // HAVENDO MODELS VINCULADOS
      // Verifica se ha registros vinculados em outras tabelas
      if(count($linkedModels) > 0){

        // percorre os models vinculados
        $counter = 0; // contar numero de registros vinculados
        for ($i=0; $i < count($linkedModels) ; $i++) { 
          
          $element = $linkedModels[$i];
          
          // percorre os nomes das colunas de chave estrangeira
          for ($j=0; $j <count($columnInModels) ; $j++) { 
            
            $colum = $columnInModels[$j];
            
            // verifica se ha pelo menos 1 registro vinculado nos demais models
            $countRegister = $element->where($colum, $id)->get()->count(); 

            // Achando um registro retorna o nome da tabela vinculada

            if($countRegister > 0){

              $table = $element->getTable();

              switch($table){
                case 'atendimento':
                  $table = 'tabela de atendimentos';
                  break;
                case 'atendimentoexame':
                  $table = 'tabela de exames';
                  break;
                case 'atendimentorisco':
                  $table = 'tabela de riscos';
                  break;
                case 'coordenador':
                  $table = 'tabela de coordenadores';
                  break;
                case 'empregado':
                  $table = 'tabela de empregados';
                  break;
                case 'exame':
                  $table = 'tabela de exames';
                  break;
                case 'formulario':
                  $table = 'tabela de formularios';
                  break;
                case 'funcao':
                  $table = 'tabela de funções';
                  break;
                case 'grupo':
                  $table = 'tabela de grupos';
                  break;
                case 'grupoexame':
                  $table = 'tabela de exames';
                  break;
                case 'grupofuncao':
                    $table = 'tabela de funções x setores';
                    break;
                case 'gruporisco':
                  $table = 'tabela de riscos';
                  break;
                case 'permissao':
                  $table = 'tabela de permissões';
                  break;
                case 'risco':
                  $table = 'tabela de riscos';
                  break;
                case 'setor':
                  $table = 'tabela de setores';
                  break;
                case 'tipoatendimento':
                  $table = 'tabela de atendimentos';
                  break;
                case 'tiporisco':
                  $table = 'tabela de tipos de riscos';
                  break;
                case 'tipousuario':
                  $table = 'tabela de usuarios';
                  break;
      
                  default:
                  echo '';
              }

            }

            $counter = $counter + $countRegister;
            
          }

        }

        // Havendo registros em models vinculados
        if($counter > 0)
        {
          return FailRedirectMessage::failRedirect($routeError, ['errors' => "Há registros vinculados a $table"], $id);
        }

        // SEM registros em models vinculados
        else{
          
          $deletedRegister = $register->delete();
          
          if($deletedRegister)
          {
            return SuccessRedirectMessage::successRedirect($routeSuccess, $msgSuccess, $id);
          }
          else
          {
            return FailRedirectMessage::failRedirect($routeError, ['errors' => 'Falha no delete'], $id);
          }
          
        }
      }

      // NAO EXISTE MODELS VINCULADOS

      $deletedRegister = $register->delete();

      if($deletedRegister){

        return SuccessRedirectMessage::successRedirect($routeSuccess, $msgSuccess, $mainId);

      }else{

        return FailRedirectMessage::failRedirect($routeError, ['errors' => 'Falha no delete'], $mainId);

      }

    }
}

// Nao pode ter este else aqui pois deve finalizar todo o for primeiro
            // else{
            //   $deletedRegister = $register->delete();

            //   if($deletedRegister){

            //     return SuccessRedirectMessage::successRedirect($routeSuccess, $msgSuccess, '');

            //   }
            //   else
            //   {
            //     return FailRedirectMessage::failRedirect($routeError, $msgError, '');

            //   }
            // }