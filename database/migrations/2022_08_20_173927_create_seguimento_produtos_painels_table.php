<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimentoProdutosPainelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimento_produtos_painels', function (Blueprint $table) {
            $table->id();
            $table->string('nome_seguimento');
            $table->string('nome_imagem');
            $table->string('url_imagem');
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
        Schema::dropIfExists('seguimento_produtos_painels');
    }
}
