    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="noprint">
        <ul class="sidebar-nav">
            {{-- <li class="text-center"><a href="{{ route('home') }}"><img src={{ asset('images/logo2.png') }}
                        width="150" /></a></li> --}}
            {{-- <li class="menu-header"><i class="fa fa-user-circle"></i> &nbsp; {{ Auth::user()->name }} --}}
            {{-- </li> --}}

            <div class="pl-5">
                <li class="menu-header">Gestione contenuti</li>
                <li class="menu"><a href="#"><i class="fas fa-plus fa-fw"></i>
                        Aggiungi un post</a></li>
                <li class="menu"><a href="#"><i class="fas fa-camera fa-fw"></i>
                        Fotogallery</a></li>
                <br>
                <li class="menu-header">Gestione campionati</li>

                @php $activeSeason = App\Models\Season::active(); @endphp
                @if ($activeSeason)
                    <li class="menu"><a href="{{ route('admin.season.show', $activeSeason) }}"><i
                                class="fas fa-calendar fa-fw"></i>
                            {{ $activeSeason->name }}</a></li>
                @endif
                <li class="menu"><a href="{{ route('admin.season.create') }}"><i class="fas fa-plus fa-fw"></i>
                        Aggiungi una stagione</a></li>

                @foreach (App\Models\Season::where('favorite', true) as $season)
                    <li class="menu"><a href="#">{{ $season->name }}</a>
                    </li>
                @endforeach

                <li class="menu"><a href="{{ route('admin.season.index') }}"><i class="fas fa-edit fa-fw"></i>
                        Gestisci stagioni</a></li>

        </ul>
    </div>
    <!-- /#sidebar-wrapper -->
