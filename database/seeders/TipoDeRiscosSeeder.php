<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoRisco;

class TipoDeRiscosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoRisco = new TipoRisco();
        $tipoRisco->insert(['nome' => 'Fisico']);
        $tipoRisco->insert(['nome' => 'Quimico']);
        $tipoRisco->insert(['nome' => 'Sem Riscos']);
        $tipoRisco->timeStamps =false;
        $tipoRisco->save();
      
    }
}
