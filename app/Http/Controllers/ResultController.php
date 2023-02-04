<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Models\Result;
use App\Models\CPVolleyParser;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('result.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        return view('result.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResultRequest  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResultRequest $request, Result $result)
    {
        // Aggiorno i dati della squadra ospite
        $setWon = [$request->home_score, $request->visitor_score];
        $isWinner = CPVolleyParser::isWinner($setWon, CPVolleyParser::HOME_TEAM);
        $score = CPVolleyParser::getScore($setWon, CPVolleyParser::HOME_TEAM);
        $result->teams()->updateExistingPivot(
            $result->teams[CPVolleyParser::HOME_TEAM]->id,
            [
                'winner' => $isWinner,
                'loser' => !$isWinner,
                'score' => $score[CPVolleyParser::HOME_TEAM],
                'set_won' => $request->home_score,
                'set_lost' => $request->visitor_score,
                'set_1' => $request->home_set_1,
                'set_2' => $request->home_set_2,
                'set_3' => $request->home_set_3,
                'set_4' => $request->home_set_4,
                'set_5' => $request->home_set_5,
            ]
        );

        // Aggiorno i dati della squadra ospite
        $setWon = [$result->home_score, $result->visitor_score];
        $isWinner = CPVolleyParser::isWinner($setWon, CPVolleyParser::VISITOR_TEAM);
        $score = CPVolleyParser::getScore($setWon, CPVolleyParser::VISITOR_TEAM);
        $result->teams()->updateExistingPivot(
            $result->teams[CPVolleyParser::VISITOR_TEAM]->id,
            [
                'winner' => $isWinner,
                'loser' => !$isWinner,
                'score' => $score[CPVolleyParser::VISITOR_TEAM],
                'set_won' => $request->visitor_score,
                'set_lost' => $request->home_score,
                'set_1' => $request->visitor_set_1,
                'set_2' => $request->visitor_set_2,
                'set_3' => $request->visitor_set_3,
                'set_4' => $request->visitor_set_4,
                'set_5' => $request->visitor_set_5,
            ]
        );

        return redirect(route('admin.result.show', compact('result')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }
}
