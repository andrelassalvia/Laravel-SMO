<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiscosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risco', function (Blueprint $table) {
            $table->id();
            $table->String('nome', 50)->unique();
            $table->unsignedBigInteger('tiporisco_id');
            $table->foreign('tiporisco_id')->references('id')->on('tiporisco');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risco');
    }
}
