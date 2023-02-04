<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeasonRequest;
use App\Http\Requests\UpdateSeasonRequest;
use App\Models\Season;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seasons = Season::all();

        return view('season.index', compact('seasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('season.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSeasonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeasonRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $season = Season::create($validatedData);

        $seasons = Season::all();
        return redirect()->route('admin.season.index', compact('seasons'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season)
    {
        return view('season.show', compact('season'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function edit(Season $season)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSeasonRequest  $request
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeasonRequest $request, Season $season)
    {
        $season->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(Season $season)
    {
        Season::destroy($season->id);

        // TODO: Cancellare anche tutti i tornei ad essa associati

        return redirect(route('admin.season.index'));
    }

    public function activate($seasonId)
    {
        $season = Season::find($seasonId);
        $season->setActive();

        return "Done " . $season->id;
    }
}
