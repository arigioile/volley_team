<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Season extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Riporta l'elenco di squadre che partecipano ai vari tornei che sono presenti
     * in una stagione.
     */
    public function teams()
    {
        $teamIds = $this->hasManyThrough(Ranking::class, Tournament::class)->pluck('team_id');
        return Team::whereIn('id', $teamIds)->get();
    }

    /**
     * Riporta l'elenco di squadre APPARTENENTI AL SITO che partecipano ai vari tornei
     * che sono presenti in una stagione.
     */
    public function myTeams()
    {
        return $this->teams()->where('my_team', true);
    }

    /**
     * Riporta l'elenco dei tornei VISIBILI a cui le squadre APPARTENENTI AL SITO partecipano (relative a questa stagione)
     */
    public function myTournaments()
    {
        $tournamentIds = Ranking::join('teams', 'teams.id', 'team_tournament.team_id')
            ->where('my_team', 'on')
            ->pluck('tournament_id');
        return $this->tournaments()
            ->whereIn('id', $tournamentIds)
            ->where('hidden', 0);
    }

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    /**
     * Indica se il tornato è attivo o meno
     *
     * @return boolean
     */
    public function getIsActiveAttribute()
    {
        $activeSeasonId = Setting::valueForKey('active_season_id');
        return ($this->id == $activeSeasonId);
    }

    /**
     * Imposta questa stagione come attiva
     * @return Season
     */
    public function setActive()
    {
        Setting::setValueForKey('active_season_id', $this->id);

        return $this;
    }

    /**
     * Riporta la stagione in corso
     * @return Season
     */
    public static function active()
    {
        $activeSeasonId = Setting::valueForKey('active_season_id');

        // Ho trovato la stagione attiva
        if ($activeSeasonId > 0) return Season::find($activeSeasonId);

        return null;
    }
}
