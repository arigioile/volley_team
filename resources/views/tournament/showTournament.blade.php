@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row pb-4">
                    <div class="d-flex justify-content-between">
                        <div class="pt-2">
                            <p class="fs-3 text-black-50 pb-0 mb-0"><span class="fw-bold fs-3">{{ $tournament->name }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                @php
                    $tab = 'calendario';
                @endphp
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab == 'calendario' ? 'active' : '' }}" id="calendario-tab"
                            data-bs-toggle="tab" data-bs-target="#calendario" type="button" role="tab"
                            aria-controls="calendario" aria-selected="true">Calendario</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab == 'classifica' ? 'active' : '' }}" id="classifica-tab"
                            data-bs-toggle="tab" data-bs-target="#classifica" type="button" role="tab"
                            aria-controls="classifica" aria-selected="false">Classifica</button>
                    </li>
                    @foreach ($my_teams->get() as $team)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $tab == 'myMatches_$team->id' ? 'active' : '' }}"
                                id="myMatches_{{ $team->id }}-tab" data-bs-toggle="tab"
                                data-bs-target="#myMatches_{{ $team->id }}" type="button" role="tab"
                                aria-controls="myMatches_{{ $team->id }}"
                                aria-selected="false">{{ $team->name }}</button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    <br>
                    <div class="tab-pane fade-in {{ $tab == 'calendario' ? 'active' : '' }}" id="calendario">
                        @foreach ($tournament->rounds() as $round)
                            @include('tournament.show_round', ['hide' => ['edit']])
                        @endforeach
                    </div>

                    <div class="tab-pane fade-in {{ $tab == 'classifica' ? 'active' : '' }}" id="classifica">
                        <div class="card mt-3">
                            <div class="card-body">
                                <table class="table table-borderless align-middle">
                                    <tr>
                                        <td>Squadra</td>
                                        <td class="text-center">Punti</td>
                                        <td class="text-end">G</td>
                                        <td class="text-end">V</td>
                                        <td class="text-end">P</td>
                                        <td class="text-end">V</td>
                                        <td class="text-end">P</td>
                                    </tr>

                                    @foreach ($tournament->ranking as $team)
                                        <tr>
                                            <td>
                                                <div class="h5 pt-1">
                                                    {{ $team->name }}
                                                    @if ($team->my_team)
                                                        &nbsp;<i class="fas fa-heart fs-6"
                                                            style="color: rgb(216, 65, 19)"></i>
                                                    @endif

                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="h5 pt-1">
                                                    {{ $team->pivot->score }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="h5 pt-1">
                                                    {{ $team->pivot->match_won + $team->pivot->match_lost }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="h5 pt-1">
                                                    {{ $team->pivot->match_won }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="h5 pt-1">
                                                    {{ $team->pivot->match_lost }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="h5 pt-1">
                                                    {{ $team->pivot->set_won }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="h5 pt-1">
                                                    {{ $team->pivot->set_lost }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    @foreach ($my_teams->get() as $team)
                        <div class="tab-pane fade-in {{ $tab == 'myMatches_$team->id' ? 'active' : '' }}"
                            id="myMatches_{{ $team->id }}">

                            <table class="table table-borderless">
                                @foreach ($tournament->rounds() as $results)
                                    @foreach ($results as $result)
                                        @if ($result->home_team->id == $team->id || $result->visitor_team->id == $team->id)
                                            <tr>
                                                <td class="text-center">
                                                    <div>
                                                        {{ $result->date }} &middot; {{ $result->time }}
                                                    </div>
                                                    <div class="h5">
                                                        {{ $result->home_team->name }}
                                                        &middot;
                                                        {{ $result->visitor_team->name }}
                                                    </div>
                                                    <div class="h5">
                                                        {{ $result->home_set_won }}
                                                        &middot;
                                                        {{ $result->visitor_set_won }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                    @endforeach

                </div>


            </div>
        </div>
    </div>
@endsection
