<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->uuid('cons_codigo');
            $table->unsignedBigInteger('pac_id');
            $table->unsignedBigInteger('med_id');
            $table->string('particula');
            $table->string('cons_data');
            $table->string('cons_hora');
            $table->timestamps();


            $table->foreign('pec_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('med_id')->references('id')->on('medicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}
