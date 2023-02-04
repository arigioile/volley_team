@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="h3">
                    Crea un nuova stagione
                </div>
                <br>
                <div>
                    <form method="POST" action="{{ route('admin.season.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <label for="name" class="col-form-label">{{ __('Nome della nuova stagione') }}</label>

                            &nbsp;&nbsp;&nbsp;

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    placeholder="es: 2022/23" value="{{ old('name') }}" required
                                    autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            &nbsp;&nbsp;&nbsp;

                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> &nbsp;&nbsp;
                                    {{ __('Aggiungi nuova stagione') }}
                                </button>
                            </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
