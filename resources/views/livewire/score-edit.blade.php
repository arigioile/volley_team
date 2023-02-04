<div>
    <div class="">

        <form method="POST" action="{{ route('admin.result.update', $result) }}">
            @csrf
            @method('put')
            <input type="hidden" id="home_score" name="home_score" value="{{ $this->homeScore }}">
            <input type="hidden" id="visitor_score" name="visitor_score" value="{{ $this->visitorScore }}">

            <table class="table table-borderless align-middle">
                <tr>
                    <td class="h5 text-end">
                        {{ $result->home_team->name }}
                    </td>
                    <td class="text-center">
                        vs
                    </td>
                    <td class="h5">
                        {{ $result->visitor_team->name }}
                    </td>
                </tr>
                <tr>
                    <td class="h2 text-end">
                        {{ $this->homeScore }}
                    </td>
                    <td class="text-center">
                        -
                    </td>
                    <td class="h2">
                        {{ $this->visitorScore }}
                    </td>
                </tr>

                @php
                    $label = ['', 'I', 'II', 'III', 'IV', 'V'];
                @endphp
                @for ($i = 1; $i <= 5; $i++)
                    <tr>
                        <td>
                            <input id="home_set_{{ $i }}" type="text"
                                class="form-control @error('home_set_{{ $i }}') is-invalid @enderror text-end"
                                name="home_set_{{ $i }}" wire:model="homeSet.{{ $i - 1 }}"
                                wire:change="scoreUpdate" {{ $this->editabled ? null : 'disabled' }}>

                            @error('home_set_{{ $i }}')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                        <td class="text-center">
                            {{ $label[$i] }}
                        </td>
                        <td>
                            <input id="visitor_set_{{ $i }}" type="text"
                                class="form-control @error('visitor_set_{{ $i }}') is-invalid @enderror"
                                name="visitor_set_{{ $i }}" wire:model="visitorSet.{{ $i - 1 }}"
                                wire:change="scoreUpdate" {{ $this->editabled ? null : 'disabled' }}>

                            @error('visitor_set_{{ $i }}')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                    </tr>
                @endfor
            </table>

            @if ($this->editabled)
                <div class="col-md-12 pt-1" style="text-align: right">
                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                </div>
            @endif

        </form>
    </div>

</div>
