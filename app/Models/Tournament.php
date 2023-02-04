<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class)
            ->using(Ranking::class)
            ->withPivot([
                "score",
                "match_won",
                "match_lost",
                "set_won",
                "set_lost",
            ]);
    }

    public function ranking()
    {
        return $this->teams()
            ->orderByPivot('score', 'desc')
            ->orderByPivot('match_won', 'desc')
            ->orderByPivot('set_won', 'desc')
            ->orderByPivot('set_lost', 'asc')
            ->orderBy('name')
            ;
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function rounds()
    {
        return $this->results->groupBy('round');
    }

    /**
     * Ricalcola la classifica del torneo
     */
    public function updateRanking()
    {
        foreach ($this->teams as $team) {
            $score = $team->results->where('tournament_id', $this->id)->sum('pivot.score');
            $setWon = $team->results->where('tournament_id', $this->id)->sum('pivot.set_won');
            $setLost = $team->results->where('tournament_id', $this->id)->sum('pivot.set_lost');
            $matchWon = $team->results->where('tournament_id', $this->id)->sum('pivot.winner');
            $matchLost = $team->results->where('tournament_id', $this->id)->sum('pivot.loser');

            $this->teams()->syncWithoutDetaching([
                $team->id => [
                    "score" => $score,
                    "match_won" => $matchWon,
                    "match_lost" => $matchLost,
                    "set_won" => $setWon,
                    "set_lost" => $setLost,
                ]
            ]);
        }
    }


    /**
     * Riporta il numero di giornate disputate nel torneo
     *
     * @return integer
     */
    public function matchDone()
    {
        $max = 0;
        foreach ($this->ranking as $team) {
            // TODO: Valutare se è il metdo giusto
            $max = max($max, $team->pivot->match_won + $team->pivot->match_lost);
        }
        return $max;
    }
}
