<div>
    <table class="table table-borderless align-middle">
        <tr>
            <td>
                Mostra carousel
            </td>
            <td>
                <div class="">
                    <div class="custom-switch custom-switch-label pt-2">
                        <input class="custom-switch-input" id="show_carousel" name="show_carousel" type="checkbox"
                            wire:click="updateCarousel" wire:model="showCarousel" />
                        <label class="custom-switch-btn" for="show_carousel"></label>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                Mostra avviso
            </td>
            <td>
                <div class="">
                    <div class="custom-switch custom-switch-label pt-2">
                        <input class="custom-switch-input" id="show_notice" type="checkbox" wire:click="updateAlert"
                            wire:model="showNotice" />
                        <label class="custom-switch-btn" for="show_notice"></label>
                    </div>
                </div>
            </td>
        </tr>
        <tr>

                <td>
                    <input id="noticeTitle" type="text"
                        class="form-control @error('noticeTitle') is-invalid @enderror" name="noticeTitle"
                        wire:model="noticeTitle">

                    @error('noticeTitle')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    <input id="noticeSubtitle" type="text"
                        class="form-control @error('noticeSubtitle') is-invalid @enderror" name="noticeSubtitle"
                        wire:model="noticeSubtitle">

                    @error('noticeSubtitle')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    <select wire:model="noticeIcon" name="noticeIcon" id="noticeIcon">
                        <option value="far fa-bell">Campanella</option>
                        <option value="far fa-alarm-clock">Sveglia</option>
                        <option value="far fa-envelope">Busta</option>
                        <option value="far fa-snowflake">Fiocco Neve</option>
                        <option value="far fa-glass-cheers">Festa</option>
                        {{-- TODO: Aggiungerne altri --}}
                      </select>


                      <select wire:model="noticeBackgroundColor" name="noticeBackgroundColor" id="noticeBackgroundColor">
                        <option value="red">Rosso</option>
                        <option value="#777700">Giallo</option>
                        <option value="#00AA00">Verde</option>
                        {{-- TODO: Aggiungerne altri --}}
                      </select>

                </td>
                <td>
                    <div class="col-md-12" style="text-align: right">
                        <button class="btn btn-primary" wire:click="saveNotice">Aggiorna avviso</button>
                    </div>
                </td>
        </tr>
    </table>
</div>
