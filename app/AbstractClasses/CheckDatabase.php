<?php

namespace App\AbstractClasses;

use Illuminate\Database\Eloquent\Model;

class CheckDataBase
{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function checkInDatabase(string $column, array $data)
  {
    $checkDatabase = $this->model->where($column, $data)->get()->first();

    return $checkDatabase;

  }
}