<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaMarcadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulta_marcadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cons_id');
            $table->unsignedBigInteger('pac_id');
            $table->unsignedBigInteger('med_id');
            $table->unsignedBigInteger('proc_id');
            $table->string('particular');
            $table->string('nr_contrato');
            $table->timestamps();


            $table->foreign('cons_id')->references('id')->on('consultas')->onDelete('cascade');
            $table->foreign('pac_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('med_id')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreign('proc_id')->references('id')->on('procedimentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulta_marcadas');
    }
}
