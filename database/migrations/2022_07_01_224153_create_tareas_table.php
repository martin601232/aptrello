<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string("titulo");
            $table->string("descripcion");
            $table->date("vence");
            $table->string("orden");
            $table->boolean("estado");
            $table->bigInteger("usuario_id")->unsigned();
            $table->foreign("usuario_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table->bigInteger("lista_id")->unsigned();
            $table->foreign("lista_id")
                ->references("id")
                ->on("listas")
                ->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
};
