<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('clave');
            $table->bigInteger('cupo');
            $table->string('periodo');
            $table->foreignId('profesores_id') ->nullable()
            ->constrained()
            ->onDelete('set null');
            $table->foreignId('materias_id') ->nullable()
            ->constrained()
            ->onDelete('set null');
            $table->foreignId('horarios_id') ->nullable()
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
        Schema::dropIfExists('cursos');
    }
}
