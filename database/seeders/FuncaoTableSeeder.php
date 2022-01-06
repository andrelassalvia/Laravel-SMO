<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funcao;

class FuncaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $funcao = new Funcao(array(
           'nome' => 'Mecanico'
       ));

       $funcao->timestamps = false;
       $funcao->save();

    }
}
