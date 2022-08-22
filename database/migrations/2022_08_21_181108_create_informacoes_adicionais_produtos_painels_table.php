<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacoesAdicionaisProdutosPainelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacoes_adicionais_produtos_painels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->longText('informacoes_adicionais_do_produto');
            $table->timestamps();

            $table->foreign('produto_id')->references('id')->on('produtos_painels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informacoes_adicionais_produtos_painels');
    }
}
