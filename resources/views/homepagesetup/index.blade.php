@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row offset-md-2 col-md-9">
                <div class="row h3">
                    Configurazione pagina iniziale
                </div>

                @livewire('configure-homepage')

            </div>
        </div>
    </div>
@endsection
