<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoAtendimento;

class TipoAtendimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoAtendimento = new TipoAtendimento();
        $tipoAtendimento->insert(['nome' => 'Presencial']);
        $tipoAtendimento->insert(['nome' => 'Remoto']);
        $tipoAtendimento->save();
    }
}
