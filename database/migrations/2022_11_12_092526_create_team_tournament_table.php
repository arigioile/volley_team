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
        Schema::create('team_tournament', function (Blueprint $table) {
            $table->id();

            $table->foreignId('team_id');
            $table->foreignId('tournament_id');

            // TODO: utilizzare questo campo per fare la ricerca del team mentre si parserizza
            $table->string('parser_name')->nullable(); // Nome che ha questa squadra sul sito da cui attingo i dati

            // Dati per il ranking (classifica)
            $table->tinyInteger('score')->nullable();
            $table->tinyInteger('match_won')->nullable();
            $table->tinyInteger('match_lost')->nullable();
            $table->tinyInteger('set_won')->nullable();
            $table->tinyInteger('set_lost')->nullable();

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
        Schema::dropIfExists('team_tournament');
    }
};
