<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $number = 0;

        $items = [
            "Asd Audace",
            "SS.Redentore",
            "Fulgur Mixer Bagnacavallo",
            "Riolo Volley",
            "Modivolley",
            "CUSB Ravenna",
            "Rapid S. Bartolo",
            "CUSBOY",
            "P.G.S. Maccabeus Voltana",
            "Val Lamone Volley",
            "Csc Marradese",
            "Modivolley",
            "PSG Volley 88",
            "VBR Fusignano Rossa",
            "Oratorio Murialdo",
            "Pallavolo Alfonsine",
        ];

        return [
            'name' => $items[$number++ & 0x0F],
        ];
    }
}
