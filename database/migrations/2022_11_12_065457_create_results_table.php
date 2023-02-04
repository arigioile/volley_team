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
        Schema::create('results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tournament_id');
            $table->foreignId('home_team_id');
            $table->foreignId('visitor_team_id');

            $table->tinyInteger('round')->nullable();

            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();

            // TODO: Andranno poi messe su una tabella a parte
            $table->string('location')->nullable();
            $table->string('gym')->nullable();

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
        Schema::dropIfExists('results');
    }
};
