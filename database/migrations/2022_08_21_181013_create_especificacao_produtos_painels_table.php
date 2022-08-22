<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecificacaoProdutosPainelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especificacao_produtos_painels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->longText('especificacao_do_produto');
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
        Schema::dropIfExists('especificacao_produtos_painels');
    }
}
