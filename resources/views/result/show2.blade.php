@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <section class="subpage-content-wrp-squadre">
                    <div class="header-partita-wrp">

                        <h1>DETTAGLIO PARTITA: BINZAGO SPORT TIME A2 - USMATE VOLLEY</h1>
                        <h2>
                            <a class="set-players-btn" target="_blank" href="https://aggiornamenti.csi.milano.it"> > Inserisci
                                il risultato
                                dell'incontro</a>



                            <!--<br><a class="set-players-btn" href="https://aggiornamenti.csi.milano.it/profilo.html?step=carica_referto&incontro=2022314BA0103&girone=B&codgruppo=PVM&login=true">Carica referti</a>
            <br><a class="set-players-btn" href="#">Spostamento partita</a>-->
                        </h2>
                    </div>
                    <div class="addthis-wrp">
                        <div class="container-addthis">
                            <!-- AddThis Button BEGIN -->
                            <div class="addthis_toolbox addthis_default_style ">
                                <a class="addthis_button_preferred_1"></a>
                                <a class="addthis_button_preferred_2"></a>
                                <a class="addthis_button_preferred_3"></a>
                                <a class="addthis_button_preferred_4"></a>
                                <a class="addthis_button_compact"></a>
                                <a class="addthis_counter addthis_bubble_style"></a>
                            </div>
                            <script type="text/javascript">
                                var addthis_config = {
                                    "data_track_addressbar": true
                                };
                                addthis_config.data_track_addressbar = false;
                            </script>
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-535e8f540a080a8a"></script>
                            <!-- AddThis Button END -->
                        </div>
                    </div>

                    <div id="info-partita-wrp">
                        <div class="col col1">
                            <a href="/albo/squadre/binzago-sport-time-a2-pallavolo-mista-open-cat-a2-0232.html"
                                title="BINZAGO SPORT TIME A2">
                                <h3>BINZAGO SPORT TIME A2</h3>
                                <div class="logo-squadra-wrp"><img src="/media/loghi_societa/02001383.jpg"
                                        class="logo-squadra"></div>
                            </a>
                        </div>
                        <div class="col col2">
                            <p class="campo">SCUOLE ELEMENTARI, VIA COL DI LANA CESANO MADERNO MB</p>

                            <p class="data">12 Ott 2022<br> 21:30</p>
                            <p class="risultato">3 - 1</p>
                            <div class="set-volley-wrp">
                                <ul>
                                    <li>1° set: 25 - 14</li>
                                    <li>2° set: 20 - 25</li>
                                    <li>3° set: 25 - 18</li>
                                    <li>4° set: 25 - 19</li>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="col col3">
                            <a href="/albo/squadre/usmate-volley-pallavolo-mista-open-cat-a2-2260.html"
                                title="USMATE VOLLEY">
                                <h3>USMATE VOLLEY</h3>
                                <div class="logo-squadra-wrp"><img src="/media/loghi_societa/02001643.jpg"
                                        class="logo-squadra"></div>
                            </a>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <input type="hidden" id="codice_squadra1" value="0232" />
                    <input type="hidden" id="codice_squadra2" value="2260" />
                    <input type="hidden" id="codice_campionato" value="314" />


                    <div class="clearfix">


                        <div class="miglior_giocatori">
                            <div class="marcatori__title">
                                <h2>Migliori Giocatori</h2>
                            </div>
                            <div class="squadra_casa">
                                <h2>Squadra Casa</h2>
                                <table class="tbl-standard charts top-scorers">
                                    <tbody>
                                        <tr>
                                            <th scope="col" class="miglior_giocatore">MIGLIOR GIOCATORE</th>
                                            <th scope="col" colspan="2">RUOLO</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="set-players-btn" target="_blank"
                                                    href="https://aggiornamenti.csi.milano.it">Giocatore non indicato</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="squadra_ospite">
                                <h2>Squadra Ospite</h2>
                                <table class="tbl-standard charts top-scorers">
                                    <tbody>
                                        <tr>
                                            <th scope="col" class="miglior_giocatore">MIGLIOR GIOCATORE</th>
                                            <th scope="col" colspan="2">RUOLO</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="set-players-btn" target="_blank"
                                                    href="https://aggiornamenti.csi.milano.it">Giocatore non indicato</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>





                        <div class="fotogallery-wrp">
                            <img src="/img/albo/tit_fotogallery.jpg"
                                alt="Fotogallery incontro BINZAGO SPORT TIME A2 - USMATE VOLLEY">
                            <div class="txt-nofoto-wrp">
                                <p>Non sono presenti immagini per questa partita.</p>
                            </div>
                        </div>

                        <div class="file-upload-wrp">
                            <h4>Hai delle foto di questa partita?</h4>
                            <p>Se hai scattato delle foto di questa partita puoi condividerle con noi e con tutti gli utenti
                                del sito
                                COMITATO TERRITORIALE C.S.I. MILANO - APS!<br>
                                Inviaci le tue foto utilizzando il form qui sotto.</p>
                            <br><br>
                            <input id="fileupload" accept="image/png,image/jpeg" type="file" name="files[]" multiple>

                            <div id="progress-wrp">
                                <p class="txt">AVANZAMENTO UPLOAD</p>
                                <div id="progress" class="progress progress-success progress-striped">
                                    <div class="bar"></div>
                                </div>
                            </div>

                            <form id="form_image" action="?step=salva_immagini" method="post"
                                enctype="multipart/form-data">
                                <!-- The list of files uploaded -->
                                <div id="files">
                                    <!-- CODICE GENERATO DALLO SCRIPT PIU IN BASSO VIENE MESSO QUI -->
                                </div>
                                <!---///////////// SCRIPT LINK ////////////--->
                                <script src="/js/jquery.ui.widget.js"></script>
                                <script src="/js/jquery.iframe-transport.js"></script>
                                <script src="/js/jquery.fileupload.js"></script>
                                <!-- JavaScript used to call the fileupload widget to upload files -->
                                <script>
                                    // When the server is ready...

                                    $(function() {
                                        'use strict';

                                        // Define the url to send the image data to
                                        var url = '/public/ajax/upload.php';

                                        // Call the fileupload widget and set some parameters
                                        $('#fileupload').fileupload({
                                            url: url,
                                            dataType: 'json',
                                            formData: {
                                                incontro: $("#incontrofull").val()
                                            },
                                            start: function(e, data) {
                                                $('#progress-wrp').show();
                                                $('#progress .bar').css('width', '0');
                                                $('#progress-wrp .txt').empty().text("AVANZAMENTO UPLOAD");
                                            },
                                            done: function(e, data) {
                                                // Add each uploaded file name to the #files list
                                                $.each(data.result.files, function(index, file) {
                                                    $('<div class="item-wrp"></div>').html(
                                                        '<div class="image-wrp"><img src="/media/partite/2022314BA0103/' +
                                                        file.name +
                                                        '"></div><p>Inserisci la didascalia</p><input type="hidden" name="ids_temp[]" value="' +
                                                        file.id_temp +
                                                        '"><input type="hidden" name="images_temp[]" value="/media/partite/2022314BA0103/' +
                                                        file.name +
                                                        '"><div class="dida-wrp"><input type="text" name="didascalia[]"><br><a href="/public/ajax/upload.php" rel="' +
                                                        file.id_temp + '" class="remove">RIMUOVI</a></div>').appendTo(
                                                        '#files');
                                                });
                                                $('.email-wrp').show();
                                                $('#progress-wrp .txt').empty().text("UPLOAD TERMINATO");
                                            },
                                            progressall: function(e, data) {
                                                // Update the progress bar while files are being uploaded
                                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                                $('#progress .bar').css('width', progress + '%');
                                                /*if (progress == 100) {
                                                 $('#progress-wrp').hide();
                                                 }*/
                                            }
                                        });
                                    });
                                </script>

                                <div class="email-wrp">
                                    Inserisci la tua email: <input type="text" name="email" id="email"> <input
                                        type="submit" id="save_images" value="SALVA LE IMMAGINI">
                                    <input type="hidden" name='incontrofull' id="incontrofull" value="2022314BA0103" />
                                </div>

                                <div class="message-wrp">
                                </div>
                            </form>
                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>
                        <div class="btn-subfilter-wrp">
                            <a href="javascript:history.back(-1);" class="btn-back">Indietro</a>
                        </div>
                </section>

            </div>
        </div>
    </div>
@endsection
