<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
            Questo modello contiene i risultati di UNA squadra di UNA paartita
         */
        Schema::create('result_team', function (Blueprint $table) {
            $table->id();

            $table->foreignId('result_id');
            $table->foreignId('team_id');

            $table->boolean('winner')->default(false);
            $table->boolean('loser')->default(false);

            $table->tinyInteger('score')->default(0);
            $table->tinyInteger('set_won')->default(0);
            $table->tinyInteger('set_lost')->default(0);
            $table->tinyInteger('set_1')->nullable();
            $table->tinyInteger('set_2')->nullable();
            $table->tinyInteger('set_3')->nullable();
            $table->tinyInteger('set_4')->nullable();
            $table->tinyInteger('set_5')->nullable();

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
        Schema::dropIfExists('result_team');
    }
};
