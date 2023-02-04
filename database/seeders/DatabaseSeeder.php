<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Credenziali Amministratore
        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'a@a.a',
            'password' => Hash::make('12345678'),
        ]);

        // Creo un avviso vuoto
        \App\Models\Notice::create(['title' => 'Primo avviso']);


        // Creo un stagione
        $season = \App\Models\Season::create(['name' => '2022/23']);

        \App\Models\Team::factory()->count(14)
            ->has(\App\Models\Player::factory()->count(10))
            ->create();

        $tournament = $season->tournaments()->create(['name' => 'Torneo Ufficiale']);
        $tournament->teams()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $tournament = $season->tournaments()->create(['name' => 'Torneo Funi']);
        $tournament->teams()->sync([1, 2, 3, 4, 11, 12]);

        $tournament = $season->tournaments()->create([
            'name' => 'Open Misto girone A',
            'query' => 'https://www.cpvolley.it/faenza-lugo-ravenna/campionato/2186/{round}/open-misto-girone-a'
        ]);

    }
}
