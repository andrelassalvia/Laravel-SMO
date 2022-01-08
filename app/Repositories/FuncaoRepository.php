<?php

namespace App\Repositories;

use App\Models\Funcao;
use App\Repositories\Interfaces\FuncaoInterface;



class FuncaoRepository implements FuncaoInterface{

  public function __construct(Funcao $funcao){
    $this->funcao = $funcao;
  }

  public function allOrdered($column, $order, $number){
    return $this->funcao->orderBy($column, $order)->paginate($number);
  }

  public function checkDb($column, $operator, $lookFor){
    return $this->funcao->where($column, $operator, $lookFor)->get()->first();
  }

  public function insert($data){
    return $this->funcao->insert($data);
  }

  public function successRedirect($route, $msg){
    return redirect()->route($route)->with($msg)->withInput();
  }

  public function failRedirect($route, $msg, $id){
    return redirect()->route($route, $id)->withErrors($msg)->withInput();
  }

  public function search($column, $operator, $lookFor, $order, $number){
    return $this->funcao->where($column, $operator, $lookFor)->orderBy($column, $order)->paginate($number);
       
  }
  
  public function get($id){
    return $this->funcao->find($id);
  }

  public function update($var, array $data){
    return $var->update($data);
  }

  public function delete($var){
    return $var->delete();
  }
  
}