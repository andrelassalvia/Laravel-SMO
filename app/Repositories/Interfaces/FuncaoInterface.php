<?php

namespace App\Repositories\Interfaces;

interface FuncaoInterface{

  public function allOrdered($column, $order, $number);

  public function get($id);

  public function checkDb($column, $operator, $lookFor);

  public function insert(array $data);

  public function successRedirect($route, array $msg);

  public function failRedirect($route, array $msg, $id);

  public function update($var, array $data);

  public function delete($var);

}