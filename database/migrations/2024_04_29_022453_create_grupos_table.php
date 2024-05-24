<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('clave');
            $table->bigInteger('cupo');
            $table->foreignId('users_id') ->nullable()
            ->constrained()
            ->onDelete('set null');
            $table->foreignId('materias_id') ->nullable()
            ->constrained()
            ->onDelete('set null');
            $table->foreignId('periodos_id') ->nullable()
            ->constrained()
            ->onDelete('set null');
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
        Schema::dropIfExists('grupos');
    }
}
