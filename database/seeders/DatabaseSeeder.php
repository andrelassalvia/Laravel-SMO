<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(TipoUsuarioSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(FuncaoTableSeeder::class);
        $this->call(TipoDeRiscosSeeder::class);
        $this->call(TipoAtendimentoSeeder::class);
    }
}
