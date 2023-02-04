<div class="card mt-3">
    <div class="card-header h4">
        Giornata {{ $round[0]->round }}
    </div>
    <div class="card-body">
        <table class="table table-borderless align-middle">
            <tr>
                @if (!in_array('edit', $hide))
                    <td></td>
                @endif
                <td></td>
                <td>Data e luogo</td>
                <td></td>
                <td>Squadra</td>
                <td class="text-center">Risultato</td>
                <td class="text-center">I</td>
                <td class="text-center">II</td>
                <td class="text-center">III</td>
                <td class="text-center">IV</td>
                <td class="text-center">V</td>
            </tr>
            @foreach ($round as $result)
                <tr>
                    @if (!in_array('edit', $hide))
                        <td style="width: 20px">
                            <a href="{{ route('admin.result.show', $result) }}" class="btn btn-xs">
                                <i class="fa fa-edit fa-fw"></i>
                            </a>
                        </td>
                    @endif
                    <td class="text-center fs-small">
                        @if ($result->images->count() > 0)
                            <i class="fas fa-images"></i>
                            <br>
                            {{ $result->images->count() }} foto
                        @endif
                    </td>
                    <td class="text-black-50 small">
                        <div>
                            {{ $result->date }} &middot; {{ $result->time }}
                        </div>
                        <div>
                            {{ $result->gym }} &middot; {{ $result->location }}
                        </div>
                    </td>
                    <td style="width: 40px">
                        <div class="h5 pt-1 text-end">
                            @if ($result->home_wins)
                                <i class="fas fa-volleyball-ball" style="color: rgb(244, 198, 45)"></i>
                            @else
                                &nbsp;
                            @endif
                        </div>
                        <div class="h5 pt-1 text-end">
                            @if ($result->visitor_wins)
                                <i class="fas fa-volleyball-ball" style="color: rgb(244, 198, 45)"></i>
                            @else
                                &nbsp;
                            @endif
                        </div>
                    </td>
                    <td class=" ">
                        <div class="h5 pt-1">
                            {{ $result->home_team->name }}
                            @if ($result->home_team->my_team)
                                &nbsp;<i class="fas fa-heart fs-6" style="color: rgb(216, 65, 19)"></i>
                            @endif
                        </div>
                        <div class="h5 pt-1">
                            {{ $result->visitor_team->name }}
                            @if ($result->visitor_team->my_team)
                                &nbsp;<i class="fas fa-heart fs-6" style="color: rgb(216, 65, 19)"></i>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="h5 pt-1">
                            {{ $result->home_set_won }}
                        </div>
                        <div class="h5 pt-1">
                            {{ $result->visitor_set_won }}
                        </div>
                    </td>

                    @for ($i = 1; $i <= 5; $i++)
                        @if ($result->matchPlayed())
                            <td class="text-black-50 text-center" style="width: 20px">
                                <div class="h6 pt-1">
                                    {{ $result->teams[0]->pivot['set_' . $i] }}
                                </div>
                                <div class="h6 pt-1">
                                    {{ $result->teams[1]->pivot['set_' . $i] }}
                                </div>
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endfor

                </tr>
            @endforeach
        </table>
    </div>
</div>
