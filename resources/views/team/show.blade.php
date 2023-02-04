@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="d-flex justify-content-between">
                        <div class="pt-2">
                            <p class="fs-3 text-black-50 pb-0 mb-0">Squadra: <span
                                    class="fw-bold fs-3">{{ $team->name }}</span>
                            </p>
                            <small>
                                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i> indietro</a>
                            </small>
                        </div>

                        {{-- <form method="POST" action="{{ route('admin.tournament.destroy', [$season->id, $tournament->id]) }}"
                            onclick="return confirm('Vuoi davvero eliminare questo torneo?');">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-outline-danger mt-3">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form> --}}
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.team.update', $team) }}">
                    @csrf
                    @method('put')
                    <div class="d-flex">
                        <div class="pt-2">
                            E' una squadra di questa società &nbsp;
                        </div>
                        <div class="custom-switch custom-switch-label pt-2">
                            <input class="custom-switch-input" id="my_team" name="my_team" type="checkbox"
                            {{ $team->my_team ? 'checked' : null }}
                            {{-- wire:click="updateAlert"
                            wire:model="showNotice"  --}}
                            />
                            <label class="custom-switch-btn" for="my_team"> </label>
                        </div>
                    </div>

                    <div class="col-md-12 pt-1" style="text-align: right">
                        <button type="submit" class="btn btn-primary">Salva modifiche</button>
                    </div>
                </form>


                {{-- @livewire('tournament-show', [
                    'season' => $season,
                    'tournament' => $tournament,
                    ]) --}}

            </div>
        </div>
    </div>
@endsection
