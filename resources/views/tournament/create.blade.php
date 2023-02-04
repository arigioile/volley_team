@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <form method="POST" action="{{ route('admin.tournament.store', $season) }}" enctype="multipart/form-data" class="row d-flex">
                    @csrf
                    {{-- <input type="hidden" name="season_id" value="{{ $season->id }}" /> --}}

                    <div class="row mb-3">
                        <label for="name"
                            class="col-md-3 col-form-label text-md-end">{{ __('Nome del nuovo torneo') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-plus"></i> &nbsp;&nbsp;
                                {{ __('Crea nuovo torneo') }}
                            </button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection
