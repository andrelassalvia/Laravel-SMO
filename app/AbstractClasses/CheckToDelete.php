<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model;

abstract class CheckToDelete
{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function checkDb(
    string $id, // id of the current model 
    array $linkedModels, // array with the linked models to check
    array $columnInModels // foreign key column name
  )
  {
    if(count($linkedModels) > 0){
      // run along $linkedModels
      $counter = 0; // count number of registers
      for ($i=0; $i < count($linkedModels) ; $i++) { 
        $element = $linkedModels[$i];
        // run alog foreign key names
        for ($j=0; $j <count($columnInModels) ; $j++) { 
          $colum = $columnInModels[$j];
          // check whether there is at least one linked register
          $countRegister = $element->where($colum, $id)->get()->count();
          // $counter += $countRegister; 
    
          // finding a register return a linked table name
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
                $table = 'tabela de exames em grupos homogêneos';
                break;
              case 'grupofuncao':
                  $table = 'tabela de funções x setores';
                  break;
              case 'gruporisco':
                $table = 'tabela de riscos em grupos homogêneos';
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
                $table = '';
                break;
            }
            return [
              'table' => $table
            ];
          } 
        }
      }
    } else {
      return false;
    }
  }
}