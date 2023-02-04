<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tournaments()
    {
        // return $this->belongsToMany(Tournament::class)->using(Ranking::class);

        return $this->belongsToMany(Tournament::class)
            ->withPivot([
                "score",
                "match_won",
                "match_lost",
                "set_won",
                "set_lost",
            ]);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    public function results()
    {
        return $this->belongsToMany(Result::class)
            ->withPivot([
                'winner',
                'loser',
                'score',
                'set_won',
                'set_lost',
                'set_1',
                'set_2',
                'set_3',
                'set_4',
                'set_5',
            ]);
    }
}
