<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Models\Result;
use \App\Models\Season;
use \App\Models\Team;
use \App\Models\Player;
use \App\Models\Tournament;
use \App\Models\CPVolleyParser;

class TournamentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $season = Season::create(['name' => 'Anno 2022/23']);

        Team::factory()->count(14)
            ->has(Player::factory()->count(10))
            ->create();

        $tournament = $season->tournaments()->create(['name' => 'Torneo Ufficiale']);
        $tournament->teams()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $tournament = $season->tournaments()->create(['name' => 'Torneo Funi']);
        $tournament->teams()->sync([1, 2, 3, 4, 11, 12]);
    }

    /**
     * A basic unit test teams.
     *
     * @return void
     */
    public function test_teams()
    {
        $tournament = Tournament::find(1);
        $this->assertEquals($tournament->teams->count(), 10);

        $tournament = Tournament::find(2);
        $this->assertEquals($tournament->teams->count(), 6);
    }

    public function addResult($tournamentId, $round, $homeTeamId, $visitorTeamId, $setHome, $setVisitor)
    {
        $parser = new CPVolleyParser();

        $result = Result::firstOrCreate([
            'tournament_id' => $tournamentId,
            'home_team_id' => $homeTeamId,
            'visitor_team_id' => $visitorTeamId,
            'round' => $round,
        ]);

        $result->teams()->sync([
            $homeTeamId => [
                'set_won' => $setHome,
                'set_lost' => $setVisitor,
                'score' => $parser->getScore([$setHome, $setVisitor])[0],
                'winner' => ($setHome > $setVisitor),
                'loser' => ($setHome < $setVisitor),
            ],
            $visitorTeamId => [
                'set_won' => $setVisitor,
                'set_lost' => $setHome,
                'score' => $parser->getScore([$setHome, $setVisitor])[1],
                'winner' => ($setHome < $setVisitor),
                'loser' => ($setHome > $setVisitor),
            ],
        ]);
    }

    // ->orderByPivot('set_won', 'asc')
    // ->orderByPivot('set_lost', 'asc');
    public function test_ranking_1()
    {
        $round = 1;
        // Squadra 9: 3 pts
        $this->addResult(1, $round, 10, 9, 1, 3);

        $tournament = Tournament::find(1);
        $tournament->updateRanking();
        $ranking = $tournament->ranking()->pluck('team_id')->toArray();

        $this->assertEquals($ranking, [9, 10, 5, 7, 3, 1, 4, 8, 6, 2]);
    }

    public function test_ranking_2()
    {
        $round = 1;
        // Squadra 9: 3 pts
        $this->addResult(1, $round, 10, 9, 1, 3);

        // Squadra 1: 3 pts
        $this->addResult(1, $round, 1, 2, 3, 0);
        // [9, 1, 3, 4, 5, 6, 7, 8, 10, 2]

        // Squadra 3: 1 pts
        // Squadra 4: 2 pts
        $this->addResult(1, $round, 3, 4, 2, 3);
        // [1, 9, 4, 3, 5, 6, 7, 8, 2, 10]

        $tournament = Tournament::find(1);
        $tournament->updateRanking();
        $ranking = $tournament->ranking()->pluck('team_id')->toArray();

        $this->assertEquals($ranking, [1, 9, 4, 3, 10, 7, 5, 6, 8, 2]);
    }

    public function test_ranking_3()
    {
        $round = 1;
        // Squadra 1: W 3 pts  Squadra 3: W 2 pts
        $this->addResult(1, $round, 1, 2, 3, 1);
        $this->addResult(1, $round, 3, 4, 3, 2);

        $round = 2;
        // Squadra 1: L 1 pts  Squadra 3: W 2 pts
        $this->addResult(1, $round, 1, 5, 2, 3);
        $this->addResult(1, $round, 3, 6, 3, 2);

        $tournament = Tournament::find(1);
        $tournament->updateRanking();
        $ranking = $tournament->ranking()->pluck('team_id')->toArray();

        $this->assertEquals($ranking, [3, 1, 5, 4, 6, 2, 9, 7, 8, 10]);
    }
}
