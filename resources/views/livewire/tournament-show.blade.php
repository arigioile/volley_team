<div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mt-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tournament.update', [$season, $tournament]) }}">
                        @csrf
                        @method('put')
                        <div class="form-group col-md-12 pt-2">
                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-9">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $tournament->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>

                                <div class="col-md-9">
                                    <input id="description" type="text"
                                        class="form-control @error('description') is-invalid @enderror"
                                        name="description" value="{{ $tournament->description }}"
                                        autocomplete="description">

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Query') }}</label>

                                <div class="col-md-9">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ $tournament->query }}" autocomplete="address">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="offset-md-3 col-md-9">
                                    <label for="hidden"
                                        class="col-form-label mt-0 pt-0 text-md-end">{{ __('Nascondi questo turneo') }}</label>

                                    <span class="custom-switch custom-switch-label" style="float: right">
                                        <input class="custom-switch-input" id="hidden" name="hidden" type="checkbox"
                                            {{ $tournament->hidden ? 'checked' : null }} />
                                        <label class="custom-switch-btn" for="hidden"></label>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pt-1" style="text-align: right">
                            <button type="submit" class="btn btn-primary">Salva modifiche</button>
                        </div>
                    </form>
                </div>
            </div>



            <div class="col-lg-12 mt-3">
                <div class="card ">
                    <div class="card-header h4">
                        Sincronizzazione risultati con CP Volley
                    </div>
                    <div class="card-body">

                        <a href="{{ route('admin.tournament.download_calendar', [$season, $tournament]) }}"
                            class="btn btn-warning col-md-8 mt-3 offset-md-2
                                {{ $autosync ? '' : 'disabled' }}">
                            Scarica incontri
                        </a>
                        <a href="{{ route('admin.tournament.download_results', [$season, $tournament]) }}"
                            class="btn btn-warning col-md-8 mt-3 offset-md-2 {{ $autosync ? '' : 'disabled' }} ">
                            Scarica risultati
                        </a>
                    </div>
                    <div class="card-body">
                        Aggiorna i risultati automaticamente coi dati di CPVolley (autosync)
                        <span class="custom-switch custom-switch-label" style="float: right">
                            <input class="custom-switch-input" id="sync_tournament" name="sync_tournament"
                                type="checkbox" wire:click="updateAutosync" wire:model="autosync" />
                            <label class="custom-switch-btn" for="sync_tournament"></label>
                        </span>
                    </div>
                </div>
            </div>

        </div>




        <div class="col-lg-4">


            <div class="card mt-3">
                <div class="card-header h4">
                    Giornate disputate
                </div>
                <div class="card-body h2 text-center">
                    {{ $tournament->matchDone() }}
                </div>
            </div>


            <div class="card mt-3">
                <div class="card-header h4">
                    Classifica
                </div>
                <div class="card-body">
                    @foreach ($tournament->ranking as $team)
                        <div>
                            <div class="pt-2 pb-1">
                                <a href="{{ route('admin.team.show', $team) }}">
                                    {{ $team->name }}
                                </a>
                                <span class="" style="float: right">
                                    {{ $team->pivot->score }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @foreach ($tournament->rounds() as $round)
            @include('tournament.show_round', ['hide' => ['']])
            @endforeach
        </div>
    </div>

</div>
