<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empregado;

class EmpregadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empregado = new Empregado();
        $empregado->insert(
            [
                'nome' => 'Andre',
                'cpf' => '25411255478',
                'ctps' => '2254',
                'serie' => '66587745',
                'data_nascimento' => '1976/01/16',
                'data_admissao' => '1985/05/20',
                // 'data_demissao' => '',
                'setor_id' => '3',
                'funcao_id' => '8',
                'grupo_id' => '3'
            ]
        );
        $empregado->insert(
            [
                'nome' => 'Jailson',
                'cpf' => '66654788547',
                'ctps' => '6654',
                'serie' => '784525',
                'data_nascimento' => '2000/12/25',
                'data_admissao' => '2018/05/15',
                'data_demissao' => '2021/01/20',
                'setor_id' => '3',
                'funcao_id' => '10',
                'grupo_id' => '3'
            ]
        );
        $empregado->insert(
            [
                'nome' => 'Partenon',
                'cpf' => '89844741211',
                'ctps' => '3663',
                'serie' => '21254',
                'data_nascimento' => '1960/01/25',
                'data_admissao' => '1990/03/12',
                'data_demissao' => '2021/04/15',
                'setor_id' => '9',
                'funcao_id' => '1',
                'grupo_id' => '3'
            ]
        );
        $empregado->insert(
            [
                'nome' => 'Zeraldo',
                'cpf' => '36544785411',
                'ctps' => '3325',
                'serie' => '33365',
                'data_nascimento' => '1998/08/30',
                'data_admissao' => '2018/02/18',
                // 'data_demissao' => '',
                'setor_id' => '10',
                'funcao_id' => '11',
                'grupo_id' => '3'
            ]
        );
        $empregado->save();
    }
}
