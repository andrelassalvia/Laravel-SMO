<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           
            $table->unsignedBigInteger('tipousuario_id')->default(1);
            $table->foreign('tipousuario_id')->references('id')->on('tipousuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropForeign('users_tipousuario_id_foreign');
            $table->dropColumn('tipousuario_id');
        });
    }
}
