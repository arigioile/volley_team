@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    {{-- Tutti i miei team --}}
                    @foreach ($teams as $myTeam)
                        {{-- Tutti i tornei dove gareggia il team --}}
                        @foreach ($myTeam->tournaments as $tournament)
                            @if ($tournament->hidden)
                                @continue
                            @endif

                            <div class="col-md-8">
                                <div class="fs-4">
                                    {{ $tournament->name }}
                                </div>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td>Data</td>
                                            <td>Partita</td>
                                            <td>Risultati</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($myTeam->results->where('tournament_id', $tournament->id)->sortBy('round') as $result)
                                            <tr>
                                                <td>
                                                    {{ $result->date }}
                                                </td>
                                                <td>
                                                    <div>
                                                        <span
                                                            class="{{ $result->home_team->my_team ? 'fw-bold' : 'text-black-50' }}">
                                                            {{ $result->home_team->name }}
                                                        </span>
                                                        -
                                                        <span
                                                            class="{{ $result->visitor_team->my_team ? 'fw-bold' : 'text-black-50' }}">
                                                            {{ $result->visitor_team->name }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $result->home_set_won }} -
                                                    {{ $result->visitor_set_won }}
                                                </td>
                                                <td>
                                                    @if ($result->matchPlayed())
                                                        <a href="{{ route('admin.result.show', $result) }}"><i
                                                                class="fas fa-edit"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">

                                <div class="card setting-card m-2">
                                    <div class="card-body">
                                        <div class="h4">
                                            Classifica
                                        </div>
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <td>Squadra</td>
                                                    <td>Punti</td>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($tournament->ranking as $team)
                                                    <tr>
                                                        <td>
                                                            {{ $team->name }}
                                                        </td>
                                                        <td>
                                                            {{ $team->pivot->score }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        @endforeach
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
