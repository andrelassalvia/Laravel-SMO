<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empregado;

class Setor extends Model
{
    use HasFactory;

    protected $table = 'setor';
    protected $fillable = [
        'nome',
                        
    ];
    public $timestamps = false;

    public function collection(){
        return $this->orderBy('nome', 'ASC')->paginate(5);
    }

    public function saveInDatabase($data){
        
        $check = $this->checkDataBase($data);

        if($check == null){
            
            // inserir o nome no DB
            $insert = $this->insert(['nome' => $data]);
            
            // checar se a insercao foi feita corretamente
            if($insert){
                return $this->successRedirect('setores.index', ['success' => 'Registro Cadastrado com Sucesso']);
            }
            else{
                return $this->failRedirect('setores.create', ['errors' => 'Erro na inserção.']);
                
            }
        }
        else{
            return $check;
        }
    }

    public function changeRegister($id, $data, $form){

        $register = $this->get($id);
        
        $check = $this->checkDataBase($data);

        if($check == null){

            $update = $register->update($form);

            if($update){

                return $this->successRedirect('setores.index', ['success' => 'Funcao cadastrada com sucesso.']);
            }
            else{
                return $this->funcao->failRedirect('setores.edit', ['errors' => 'Erro na insercao']);
            }
        }
        else{
            return $check;
        }

    }

    public function erase($id){

        $register = $this->get($id);

        $search = Empregado::where('funcao_id', $id)->get()->count();

        if($search > 0){
            $msg = ['errors' => 'Falha no Delete. Existem '. $search. ' empregado(s) com esta função.'];
            return $this->failRedirect('setores.show', $msg);
        }

        $deletedRegister = $register->delete();

        if($deletedRegister){
            return $this->successRedirect('setores.index', ['success' => 'Função deletada com sucesso.']);
        }
        else{
            return $this->failRedirect('setores.show', ['errors' => 'Erro no Delete']);
        }

    }

    public function search($column, $operator, $loohFor, $order, $nPag){
        return $this->where($column, $operator, $loohFor)->orderBy($column, $order)->paginate($nPag);
    }

    public function checkDataBase($data){
     // Verifica de o nome ja esta cadastrado
        $funcao = $this->where('nome',$data)->get()->first();
        
        // Erro se ja estiver cadastrada
        if($funcao != null){
            
            return $this->failRedirect('setores.create', ['errors' => 'Funcao já cadastrada']);
            
        }
    }

    public function failRedirect($route, $msg){
        return redirect()->route($route)->withErrors($msg)->withInput();
    }

    public function insert($data){
        return $this->create($data);
    }

    public function successRedirect($route, $msg){
        return redirect()->route($route)->with($msg)->withInput();
    }

    public function get($id){
        return $this->find($id);
    }

}
