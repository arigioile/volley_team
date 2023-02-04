@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row offset-md-2 col-md-9">
                <div class="row h3">
                    Amministrazione sito
                </div>


                <div class="card setting-card col-md-3 m-2">
                    <div class="card-body">
                        <div class="h4">
                            Post
                        </div>
                        <i class="fas fa-plus fa-fw"></i> Aggiungi un post
                    </div>
                </div>

                <div class="card setting-card col-md-3 m-2">
                    <div class="card-body">
                        <div class="h4">
                            Fotogallery
                        </div>
                        Aggiungi un post
                    </div>
                </div>

                <div class="card setting-card col-md-3 m-2 bg-red">
                    <div class="card-body">
                        <div class="h4">
                            Impostazioni
                        </div>
                        <a href="{{ route('admin.homepagesetup.index') }}">
                            <i class="fa-sharp fa-solid fa-house"></i>Homepage
                        </a>
                    </div>
                </div>

                <div class="card setting-card has-bg-img bg-img-nature card-clickable col-md-3 m-2"
                    onclick="location.href = '{{ route('admin.season.index') }}'"
                    title="Clicca qui per gestire le stagioni">
                    <span class="card__title">Stagioni</span>
                    {{-- <div class="card-body">
                        <div class="h4">
                            Stagioni
                        </div>
                        Aggiungi un post
                    </div> --}}
                </div>

                @php $activeSeason = App\Models\Season::active(); @endphp
                @if ($activeSeason)
                    <div class="card setting-card card-clickable col-md-3 m-2 bg-red"
                        onclick="location.href = '{{ route('admin.season.show', $activeSeason) }}'"
                        title="Clicca qui per accedere ai dettagli della stagione">
                        <div class="card-body">
                            <div class="h4">
                                {{ $activeSeason->name }}
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
