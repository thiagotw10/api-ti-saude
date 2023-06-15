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
            $table->bigIncrements('cons_codigo');
            $table->unsignedBigInteger('cons_pac');
            $table->unsignedBigInteger('cons_med');
            $table->unsignedBigInteger('vinculo_id')->nullable();
            $table->string('data');
            $table->string('hora');
            $table->string('particular')->default('0');
            $table->timestamps();

            $table->foreign('cons_pac')->references('pac_codigo')->on('pacientes')->onDelete('cascade');
            $table->foreign('cons_med')->references('med_codigo')->on('medicos')->onDelete('cascade');
            $table->foreign('vinculo_id')->references('vinc_codigo')->on('vinculos')->onDelete('cascade');
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
