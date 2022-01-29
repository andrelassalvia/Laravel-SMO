<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoExame;
use App\Models\AtendimentoExame;


class Exame extends Model
{
    use HasFactory;

    protected $table = 'exame';

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
                return $this->successRedirect('exames.index', ['success' => 'Registro Cadastrado com Sucesso']);
            }
            else{
                return $this->failRedirect('exames.create', ['errors' => 'Erro na inserção.']);
                
            }
        }
        else{
            return $check;
        }
    }

    public function changeRegister($id, $data, $form){

        $register = $this->get($id);
        // dd($register);

        $check = $this->checkDataBase($data);

        if($check == null){

            $update = $register->update($form);

            if($update){

                return $this->successRedirect('exames.index', ['success' => 'Exame cadastrado com sucesso.']);
            }
            else{
                return $this->funcao->failRedirect('exames.edit', ['errors' => 'Erro na insercao']);
            }
        }
        else{
            return $check;
        }

    }

    public function erase($id){

        $register = $this->get($id);

        $checkGrupoExame = GrupoExame::where('exame_id',$id)->get()->count();
        $checkAtendimentoExame = AtendimentoExame::where('exame_id', $id)->get()->count();

        if($checkGrupoExame == null && $checkAtendimentoExame == null ){

        $deletedRegister = $register->delete();

        if($deletedRegister){
            return $this->successRedirect('exames.index', ['success' => 'Exame deletado com sucesso.']);
        }
        else{
            return $this->failRedirect('exames.show', ['errors' => 'Erro no Delete']);
        }

        }
        else{

            return [$checkGrupoExame, $checkAtendimentoExame];
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
            
            return $this->failRedirect('exames.create', ['errors' => 'Exame já cadastrado']);
            
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
