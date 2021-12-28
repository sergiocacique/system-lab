<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunosAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos_aulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id');
            $table->foreignId('aula_id');
            $table->boolean('checkin')->nullable();

            $table->timestamps();

            $table->foreign('aluno_id')->references('id')->on('alunos')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('aula_id')->references('id')->on('aulas')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alunos_aulas');
    }
}
