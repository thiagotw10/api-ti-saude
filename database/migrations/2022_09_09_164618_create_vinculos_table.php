<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVinculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vinculos', function (Blueprint $table) {
            $table->bigIncrements('vinc_codigo');
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('plano_saude_id');
            $table->uuid('nr_contrato');
            $table->timestamps();

            $table->foreign('paciente_id')->references('pac_codigo')->on('pacientes')->onDelete('cascade');
            $table->foreign('plano_saude_id')->references('plano_codigo')->on('plano_saudes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vinculos');
    }
}
