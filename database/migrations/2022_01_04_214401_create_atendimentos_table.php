<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atendimento', function (Blueprint $table) {
            $table->id();
            $table->date('data_atendimento');
            $table->boolean('trabalhoaltura');
            $table->boolean('espacoconfinado');
            $table->boolean('apto');
            $table->unsignedBigInteger('coordenador_id');
            $table->foreign('coordenador_id')->references('id')->on('coordenador');
            $table->unsignedBigInteger('empregado_id');
            $table->foreign('empregado_id')->references('id')->on('empregado');
            $table->unsignedBigInteger('setor_id');
            $table->foreign('setor_id')->references('id')->on('setor');
            $table->unsignedBigInteger('funcao_id');
            $table->foreign('funcao_id')->references('id')->on('funcao');
            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupo');
            $table->unsignedBigInteger('tipoatendimento_id');
            $table->foreign('tipoatendimento_id')->references('id')->on('tipoatendimento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atendimento');
    }
}
