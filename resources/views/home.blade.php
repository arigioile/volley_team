@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                @if (App\Models\Setting::valueForKey('show_carousel', false))
                    {{-- Carousel --}}
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner ">
                            @foreach ($sliders as $slider)
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    <div class="slider-image text-center">
                                        <img src="{{ $slider }}" class="d-inline-block border text-center rounded"
                                            alt="{{ $slider }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @endif


            </div>
            <br>
            <div class="col-md-10">

                @if (App\Models\Setting::valueForKey('show_notice', false))
                    <section class="spacer mt-4 mb-4 p-4">
                        <div class="container">
                            <div class="row pt-4 pb-3 "
                                style="color: {{ $notice->color }}; background-color: {{ $notice->background_color }}; border-radius: 0.4rem;
                                ">

                                    <div class="col-md-7 offset-md-1 ">
                                        <div class=" alignright flyLeft text-end">
                                            <blockquote class="h1">
                                                {{ $notice->title }}
                                            </blockquote>
                                            <cite> {{ $notice->subtitle }}
                                            </cite>
                                        </div>
                                    </div>
                                    <div class="col-md-3 offset-md-1 p-4">
                                        <div class=" aligncenter flyRight">
                                            <i class="{{ $notice->icon }}" style="font-size: 120px"></i>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </section>
                @endif

                <div class="col-md-8">
                    <div class="h3 text-center pt-4">
                        <span class="strong">
                            Attività del
                            <span style="color: #08699d;">Centro</span>
                        </span>
                    </div>
                    <div class="row">
                        <h2 class="owl-title" style="color:#111111;"></h2>
                        <div class="owl-description" style="color:#666666;">Da circa 40 anni il C.S. Santa Maria propone
                            corsi
                            di insegnamento delle principali discipline sportive per adulti e bambini, secondo i programmi
                            delle
                            varie Federazioni sportive nazionali, seguiti da uno staff di tecnici altamente qualificati in
                            un
                            ambiente unico, moderno, tranquillo e funzionale.</div>
                    </div>

                </div>

                <div class="col-md-8">
                    <div class="popup-gallery">
                        <a href="http://farm9.staticflickr.com/8242/8558295633_f34a55c1c6_b.jpg" title="The Cleaner"><img
                                src="http://farm9.staticflickr.com/8242/8558295633_f34a55c1c6_s.jpg" width="75"
                                height="75"></a>
                        <a href="http://farm9.staticflickr.com/8382/8558295631_0f56c1284f_b.jpg" title="Winter Dance"><img
                                src="http://farm9.staticflickr.com/8382/8558295631_0f56c1284f_s.jpg" width="75"
                                height="75"></a>
                        <a href="http://farm9.staticflickr.com/8225/8558295635_b1c5ce2794_b.jpg"
                            title="The Uninvited Guest"><img
                                src="http://farm9.staticflickr.com/8225/8558295635_b1c5ce2794_s.jpg" width="75"
                                height="75"></a>
                        <a href="http://farm9.staticflickr.com/8383/8563475581_df05e9906d_b.jpg"
                            title="Oh no, not again!"><img
                                src="http://farm9.staticflickr.com/8383/8563475581_df05e9906d_s.jpg" width="75"
                                height="75"></a>
                        <a href="http://farm9.staticflickr.com/8235/8559402846_8b7f82e05d_b.jpg" title="Swan Lake"><img
                                src="http://farm9.staticflickr.com/8235/8559402846_8b7f82e05d_s.jpg" width="75"
                                height="75"></a>
                        <a href="http://farm9.staticflickr.com/8235/8558295467_e89e95e05a_b.jpg" title="The Shake"><img
                                src="http://farm9.staticflickr.com/8235/8558295467_e89e95e05a_s.jpg" width="75"
                                height="75"></a>
                        <a href="http://farm9.staticflickr.com/8378/8559402848_9fcd90d20b_b.jpg"
                            title="Who's that, mommy?"><img
                                src="http://farm9.staticflickr.com/8378/8559402848_9fcd90d20b_s.jpg" width="75"
                                height="75"></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                    }
                }
            });
        });
    </script>
@endpush
