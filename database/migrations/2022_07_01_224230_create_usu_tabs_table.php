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
        Schema::create('usu_tabs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("usuario_id")->unsigned();
            $table->foreign("usuario_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table->bigInteger("tablero_id")->unsigned();
            $table->foreign("tablero_id")
                ->references("id")
                ->on("tableros")
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
        Schema::dropIfExists('usu_tabs');
    }
};
