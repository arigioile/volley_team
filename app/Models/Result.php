<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function home_team()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function visitor_team()
    {
        return $this->belongsTo(Team::class, 'visitor_team_id');
    }

    public function getHomeScoreAttribute()
    {
        if ($this->teams()->count() != 2) return "";

        return $this->teams[CPVolleyParser::HOME_TEAM]->pivot->attributes['score'];
    }

    public function getVisitorScoreAttribute()
    {
        if ($this->teams()->count() != 2) return "";

        return $this->teams[CPVolleyParser::VISITOR_TEAM]->pivot->attributes['score'];
    }

    public function getHomeSetWonAttribute()
    {
        if ($this->teams()->count() != 2) return "";

        return $this->teams[CPVolleyParser::HOME_TEAM]->pivot->attributes['set_won'];
    }

    public function getVisitorSetWonAttribute()
    {
        if ($this->teams()->count() != 2) return "";

        return $this->teams[CPVolleyParser::VISITOR_TEAM]->pivot->attributes['set_won'];
    }

    public function getHomeSetLostAttribute()
    {
        if ($this->teams()->count() != 2) return "";

        return $this->teams[CPVolleyParser::HOME_TEAM]->pivot->attributes['set_lost'];
    }

    public function getVisitorSetLostAttribute()
    {
        if ($this->teams()->count() != 2) return "";

        return $this->teams[CPVolleyParser::VISITOR_TEAM]->pivot->attributes['set_lost'];
    }

    public function getHomeWinsAttribute()
    {
        if ($this->teams()->count() != 2) return "";

        return $this->teams[CPVolleyParser::HOME_TEAM]->pivot->attributes['winner'];
    }

    public function getVisitorWinsAttribute()
    {
        if ($this->teams()->count() != 2) return "";

        return $this->teams[CPVolleyParser::VISITOR_TEAM]->pivot->attributes['winner'];
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class)
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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function matchPlayed()
    {
        return (bool)($this->home_set_won + $this->visitor_set_won);
    }
}
