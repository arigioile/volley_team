@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                @foreach ($tournaments as $tournament)
                    {{ $tournament->name }}
                @endforeach

            </div>
        </div>
    </div>
@endsection
