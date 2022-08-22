<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosPainelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_painels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seguimento_id');
            $table->string('nome_do_produto');
            $table->longText('descricao_do_produto');
            $table->string('preco_do_produto');
            $table->string('preco_do_produto_com_desconto');
            $table->string('unidades_do_produto');
            $table->string('posicao_do_produto');
            $table->timestamps();

            $table->foreign('seguimento_id')->references('id')->on('seguimento_produtos_painels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos_painels');
    }
}
