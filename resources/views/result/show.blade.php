@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row">
                    <div class="d-flex justify-content-between">
                        <div class="pt-2">
                            <p class="fs-3 text-black-50 pb-0 mb-0">Dettaglio partita: <span
                                    class="fw-bold fs-3 text-black-80">{{ $result->home_team->name }} -
                                    {{ $result->visitor_team->name }}</span>
                            </p>

                        </div>
                    </div>
                    <p class="text-uppercase">{{ $result->gym }} &middot; {{ $result->location }} - {{ $result->date }}
                        {{ $result->time }}</p>
                </div>
                <small>
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i> indietro</a>
                </small>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        @livewire('score-edit', [
                            'result' => $result,
                        ])
                    </div>
                </div>

                <div class="col-md-8">
                    <form method="post" action="{{ route('admin.result.image.upload', $result) }}" enctype="multipart/form-data"
                        class="dropzone" id="dropzone">
                        @csrf
                    </form>
                    {{-- <form method="POST" action="{{ route('image.upload') }}" enctype="multipart/form-data" class="dropzone"
                        id="dropzone">
                        <div class="dz-default dz-message">
                            <h4>Trascina qui le immagini dell'incontro</h4>
                        </div>
                    </form> --}}
                </div>
            </div>
            <br>
            <div class="col-md-8">

                <div class="gallery mt-3">
                    @if ($result->images->count() > 0)
                        @foreach ($result->images as $image)
                            <div class="card">
                                <figure class=”gallery__item">
                                    <img src="{{ asset('/images/') . '/' . $image->filename }}" alt="{{ $image->filename }}"
                                        class="gallery__img" />
                                </figure>
                                @if ($image->status == 'unknown')
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('admin.image.reject', $image->id) }}"
                                                class="btn btn-danger">Elimina</a>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.image.accept', $image->id) }}"
                                                class="btn btn-success">Autorizza</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="fotogallery-wrp">
                            <div class="txt-nofoto-wrp">
                                <p>Non sono presenti immagini per questa partita.</p>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="file-upload-wrp">
                    <h4>Hai delle foto di questa partita?</h4>
                    <p>Se hai scattato delle foto di questa partita puoi condividerle con noi e con tutti gli utenti
                        del sito
                        COMITATO TERRITORIALE C.S.I. MILANO - APS!<br>
                        Inviaci le tue foto utilizzando il form qui sotto.</p>
                    <br><br>
                    <input id="fileupload" accept="image/png,image/jpeg" type="file" name="files[]" multiple>
                </div> --}}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        Dropzone.options.dropzone = {
            maxFiles: 5,
            maxFilesize: 100,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: false,
            timeout: 5000,
            success: function(file, response) {
                console.log(response);
                location.reload();
            },
            error: function(file, response) {
                return false;
            }
        };
    </script>
@endpush
