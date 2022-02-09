<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoUsuario;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoRisco = new TipoUsuario();
        $tipoRisco->insert(['nome' => 'Administrador']);
        $tipoRisco->timeStamps =false;
        $tipoRisco->save();
    }
}
