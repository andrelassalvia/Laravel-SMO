<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formulario;

class FormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formulario = new Formulario();
        $formulario->insert(['nome' => 'Funções']);
        $formulario->insert(['nome' => 'Setores']);
        $formulario->insert(['nome' => 'Exames']);
        $formulario->insert(['nome' => 'Grupos Homogêneos']);
        $formulario->insert(['nome' => 'Riscos']);
        $formulario->insert(['nome' => 'Tipos de Atendimentos']);
        $formulario->insert(['nome' => 'Empregados']);
        $formulario->insert(['nome' => 'Coordenador de PCMSO']);
        $formulario->insert(['nome' => 'Atendimentos']);
        $formulario->save();
    }
}
