<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Models\Team;
use App\Models\Season;
use App\Models\Tournament;
use App\Models\Result;
use Symfony\Component\HttpFoundation\Request;
use App\Models\CPVolleyParser;
use Illuminate\Support\Facades\Log;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Filtrare per stagione
        $tournaments = Tournament::all();

        return view('tournament.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Season $season)
    {
        return view('tournament.create', compact('season'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTournamentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTournamentRequest $request, Season $season)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $season->tournaments()->create($validatedData);

        // $tournamens = Tournament::all();
        // return redirect('tournament.index', compact('tournaments'));

        // return back()->withInput();
        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season, Tournament $tournament)
    {
        // $ranking = $tournament->teams
        //     ->sortBy([
        //         ['pivot.score', 'desc'],
        //         ['pivot.set_won', 'desc'],
        //         ['pivot.set_lost', 'asc'],
        //         ['name', 'asc'],
        //     ]);

        return view('tournament.show', compact('season', 'tournament'));
    }

    public function showGuests(Tournament $tournament)
    {
        $my_teams = $tournament->teams()->where('my_team', 'on');
        return view('tournament.showTournament', compact('tournament', 'my_teams'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function edit(Tournament $tournament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTournamentRequest  $request
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTournamentRequest $request, Season $season, Tournament $tournament)
    {
        $tournament->update([
            'name' => $request->name,
            'description' => $request->description,
            'query' => $request->address,
            'hidden' => $request->hidden ?? false,
        ]);

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function destroy(Season $season, Tournament $tournament)
    {
        Tournament::destroy($tournament->id);

        return redirect(route('admin.season.show', $season->id));
    }

    /*
    Scarica calendario e squadre relative ad un torneo
    */
    public function downloadRoundsAndTeams(Season $season, Tournament $tournament)
    {
        $parser = new CPVolleyParser();

        // Scarico i dettagli sull'incontro
        // $url = 'https://www.cpvolley.it/faenza-lugo-ravenna/campionato/2186/{round}/open-misto-girone-a';
        $url = $tournament->query;
        for ($round = 1; $round < 1000; $round++) {
            Log::info('Parser: Download risultati giornata ' . $round);
            // $url = 'https://www.cpvolley.it/faenza-lugo-ravenna/campionato/2186/{round}/open-misto-girone-a';
            $filled_url = str_replace("{round}", $round, $url);

            // Lista degli incontri di una giornata
            $htmlText = file_get_contents($filled_url);
            $list = $parser->parseRoundMatches($htmlText);
            if ($list) {
                Log::info('Parser: Scaricata giornata ' . $round);

                // Creo i match
                foreach ($list as $item) {
                    $homeTeam = $tournament->teams()->firstOrCreate([
                        'name' =>  $item['team'][0],
                    ]);
                    $visitorTeam = $tournament->teams()->firstOrCreate([
                        'name' =>  $item['team'][1],
                    ]);

                    $result = Result::updateOrCreate([
                        'tournament_id' => $tournament->id,
                        'home_team_id' => $homeTeam->id,
                        'visitor_team_id' => $visitorTeam->id,
                        'round' => $round,
                    ], [
                        'name' => $round,
                        'date' => $item['date'],
                    ]);

                    Log::info('Parser: Found ' . $result->id . " -  " . $homeTeam->name . " - " . $visitorTeam);

                    // Aggiorno l'elenco dei team che partecipano al torneo
                    $tournament->teams()->syncWithoutDetaching([$homeTeam->id, $visitorTeam->id]);

                    // Aggiorno l'elenco delle 2 squadre che si affrontano in un incontro
                    $result->teams()->syncWithoutDetaching([$homeTeam->id, $visitorTeam->id]);
                }
            } else {
                Log::info('Parser: Fine ' . $round);
                break;
            }
        }

        // Scarico i dettagli sull'incontro
        $url = $tournament->query;
        $filled_url = str_replace("{round}", 1, $url);
        $htmlText = file_get_contents($filled_url);
        $list = $parser->parseLocationMatches($htmlText);
        if ($list) {
            foreach ($list as $item) {
                $homeTeam = $tournament->teams()->firstOrCreate([
                    'name' =>  $item['team'][0],
                ]);
                $visitorTeam = $tournament->teams()->firstOrCreate([
                    'name' =>  $item['team'][1],
                ]);

                $result = Result::updateOrCreate([
                    'tournament_id' => $tournament->id,
                    'home_team_id' => $homeTeam->id,
                    'visitor_team_id' => $visitorTeam->id,
                    'home_team_id' => $homeTeam->id,
                ], [
                    'time' => $item['time'],
                    'location' => $item['location'],
                    'gym' => $item['gym'],
                ]);
            }
        }

        return back()->withInput();
    }


    public function downloadResults(Season $season, Tournament $tournament)
    {
        $parser = new CPVolleyParser();

        // Loop tutti gliincontri del campionato
        $totRounds = $tournament->results->max('round');
        if (!$totRounds) return;

        $url = $tournament->query;
        for ($round = 1; $round <= $totRounds; $round++) {
            Log::info('Parser: Download risultati giornata ' . $round);
            // $url = 'https://www.cpvolley.it/faenza-lugo-ravenna/campionato/2186/{round}/open-misto-girone-a';
            $filled_url = str_replace("{round}", $round, $url);

            // Lista degli incontri di una giornata
            $htmlText = file_get_contents($filled_url);
            $list = $parser->parseResultMatches($htmlText);
            if ($list) {
                foreach ($list as $item) {
                    $homeTeam = $tournament->teams()->firstOrCreate([
                        'name' =>  $item['team'][0],
                    ]);
                    $visitorTeam = $tournament->teams()->firstOrCreate([
                        'name' =>  $item['team'][1],
                    ]);

                    $result = Result::firstOrCreate([
                        'tournament_id' => $tournament->id,
                        'home_team_id' => $homeTeam->id,
                        'visitor_team_id' => $visitorTeam->id,
                        'round' => $round,
                    ]);

                    $result->teams()->sync([
                        $homeTeam->id => [
                            'set_won' => $item['set_won'][0],
                            'set_lost' => $item['set_lost'][0],
                            'score' => $item['score'][0],
                            'set_1' => $item['set_1'][0],
                            'set_2' => $item['set_2'][0],
                            'set_3' => $item['set_3'][0],
                            'set_4' => $item['set_4'][0],
                            'set_5' => $item['set_5'][0],
                            'winner' => $item['winner'][0],
                            'loser' => $item['winner'][1],
                        ],
                        $visitorTeam->id => [
                            'set_won' => $item['set_won'][1],
                            'set_lost' => $item['set_lost'][1],
                            'score' => $item['score'][1],
                            'set_1' => $item['set_1'][1],
                            'set_2' => $item['set_2'][1],
                            'set_3' => $item['set_3'][1],
                            'set_4' => $item['set_4'][1],
                            'set_5' => $item['set_5'][1],
                            'winner' => $item['winner'][1],
                            'loser' => $item['winner'][0],
                        ],
                    ]);
                }
            }
        }

        // Una volta scaricati i dati, ricalcolo la classifica
        $tournament->updateRanking();

        return back()->withInput();
    }


    public function evaluateClassification(Season $season, Tournament $tournament)
    {
        $tournament->updateRanking();

        // foreach ($tournament->teams as $team) {
        //     $score = $team->results->where('tournament_id', $tournament->id)->sum('pivot.score');
        //     $setWon = $team->results->where('tournament_id', $tournament->id)->sum('pivot.set_won');
        //     $setLost = $team->results->where('tournament_id', $tournament->id)->sum('pivot.set_lost');

        //     $tournament->teams()->syncWithoutDetaching([
        //         $team->id => [
        //             "score" => $score,
        //             "set_won" => $setWon,
        //             "set_lost" => $setLost,
        //         ]
        //     ]);
        // }
    }

    // public function sync(Request $request, Season $season, Tournament $tournament)
    // {
    //     if ($request->has('checked')) {
    //         $checked = ($request->query('checked') == 'true');
    //         $tournament->update([
    //             'autosync' => $checked,
    //         ]);
    //         return $checked;
    //     }
    //     return "ERRORE 500"; // TODO: andare in errore 500
    // }
}
