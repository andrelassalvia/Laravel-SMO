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
        $tipoUsuario = new TipoUsuario();
        $tipoUsuario->insert(['nome' => 'Administrador']);
       
        $tipoUsuario->save();
    }
}
