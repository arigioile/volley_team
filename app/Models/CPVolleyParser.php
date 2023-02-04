<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;

class CPVolleyParser extends Model
{
    use HasFactory;

    public const HOME_TEAM = 0;
    public const VISITOR_TEAM = 1;

    /**
     * Riporta una stringa ripulita da eventiali caratteri "invisibili"
     * Rimuove anche gli spazi tra le parole (/sa trim())
     *
     * @param string $str stringa da ripulire
     * @return string
     */
    public static function cleanString($str)
    {
        return str_replace(array("\r\n", "\r", "\n", "\t", " "), '', $str);
    }

    /**
     * Ricevuto in ingresso il risultato dell'incontro riporta se la squadra indicata ha vinto
     *
     * @param array $matchResults risultato dell'incontro
     * @param int $teamIndex [0=squadra di casa 1=squadra ospite]
     *
     * @return boolean
     */
    public static function isWinner($matchResults, $teamIndex)
    {
        switch ($teamIndex) {
            case CPVolleyParser::HOME_TEAM: // In casa
                return ($matchResults[CPVolleyParser::HOME_TEAM] > $matchResults[CPVolleyParser::VISITOR_TEAM]);
            case 1: // Ospite
                return ($matchResults[CPVolleyParser::VISITOR_TEAM] > $matchResults[CPVolleyParser::HOME_TEAM]);
        }
    }

    /**
     * Riporta i punti classifica in base al risultato
     *
     * @param array $points punti fatti nel set
     *
     * @return array
     */
    public static function getScore($points)
    {
        // Ricavo il numero di set
        if ($points[0] > $points[1]) { // Vince la squadra di casa
            if ($points[0] == $points[1] + 1) {
                return [2, 1];
            } else {
                return [3, 0];
            }
        } else { // Vince la squadra ospide
            if ($points[0] + 1 == $points[1]) {
                return [1, 2];
            } else {
                return [0, 3];
            }
        }
    }

    /**
     * Riporta un array di 2 elementi coi punti fatti durante un set.
     * Nel caso $text non contenga 2 elementi viene riportato un array vuoto.
     *
     * @param string $text stringa contenete i risultati (es:"13-25")
     *
     * @return array
     */
    public static function getPointsForSet($text)
    {
        $dati = explode("-", CPVolleyParser::cleanString($text));

        // Devono esserci solo 2 elementi nell'array
        if (count($dati) != 2) {
            return [null, null];
        }

        // Entrambi i campi devono essere numerici
        if ((!is_numeric($dati[0])) || (!is_numeric($dati[1]))) {
            return [null, null];
        }

        return $dati;
    }

    /**
     * Riporta un array di 2 elementi indicante quale dei 2 team ha vinto il match.
     * Nel caso $text non contenga 2 elementi viene riportato un array vuoto.
     *
     * @param array $array stringa contenete i risultati (es:"3-2")
     *
     * @return array
     */
    public static function getWinner($array)
    {
        return [CPVolleyParser::isWinner($array, CPVolleyParser::HOME_TEAM), CPVolleyParser::isWinner($array, CPVolleyParser::VISITOR_TEAM)];
    }

    /**
     * Riporta tutti gli incontri di una determinata giornata (per creare il calendario)
     *
     * @param string $htmlText testo sorgente
     *
     * @return array
     */
    public function parseRoundMatches($htmlText)
    {
        Log::error('parseRoundMatches()');

        $dom = new \DomDocument();
        @$dom->loadHTML($htmlText);
        $trs = $dom->getElementsByTagName('table')[1]
            ->getElementsByTagName('tbody')[0]
            ->getElementsByTagName('tr');

        $array = array();

        // Ogni loop contiene una riga della tabella dei risultati
        foreach ($trs as $tr) {
            $tds = $tr->getElementsByTagName('td');

            // Deve contenere precisamente le colonne che voglio io
            if (($tds->length != 9) &&
                ($tds->length != 7)
            ) {
                // Log::error($url);
                Log::error('Parser: Error (length ' . $tds->length . ')');

                return null;
            }

            $result = [
                "date" => trim($tds[0]->textContent),
                "team" => [trim($tds[1]->textContent), trim($tds[2]->textContent)],
            ];

            array_push($array, $result);

            Log::info('Parser: Trovato nuovo match ' . $result["team"][CPVolleyParser::HOME_TEAM] . " - " . $result["team"][CPVolleyParser::VISITOR_TEAM]);
        }

        return $array;
    }

    /**
     * Riporta le location di dove si svolgeranno tutti gli incontri del campionato
     *
     * @param string $htmlText testo sorgente
     *
     * @return array
     */
    public function parseLocationMatches($htmlText)
    {
        Log::error('parseLocationMatches()');

        $dom = new \DomDocument();
        @$dom->loadHTML($htmlText);
        $trs = $dom->getElementsByTagName('table')[3]
            ->getElementsByTagName('tbody')[0]
            ->getElementsByTagName('tr');

        $array = array();

        // Ogni loop contiene una riga della tabella dei risultati
        foreach ($trs as $tr) {
            $tds = $tr->getElementsByTagName('td');
            if ($tds->length == 1) { // La riga che contiene il numero della giornata
                continue;
            }

            // Deve contenere precisamente le colonne che voglio io
            if ($tds->length != 8) {
                // Log::error($url);
                Log::error('Parser: Error (length ' . $tds->length . ')');

                return null;
            }

            $result = [
                "time" => trim($tds[2]->textContent),
                "location" => trim($tds[3]->textContent),
                "gym" => trim($tds[4]->textContent),
                "team" => [trim($tds[5]->textContent), trim($tds[6]->textContent)],
            ];

            array_push($array, $result);

            // Log::info('Parser: Trovato nuovo match ' . $result["team"][0] . " - " . $result["team"][1]);
        }

        return $array;
    }

    /**
     *  Riporta i risultati di una giornata
     *
     * @param string $htmlText testo sorgente
     *
     * @return array
     */
    public function parseResultMatches($htmlText)
    {
        Log::error('parseResultMatches()');

        $dom = new \DomDocument();
        @$dom->loadHTML($htmlText);
        $trs = $dom->getElementsByTagName('table')[1]
            ->getElementsByTagName('tbody')[0]
            ->getElementsByTagName('tr');

        $array = array();

        // Ogni loop contiene una riga della tabella dei risultati
        foreach ($trs as $tr) {
            $tds = $tr->getElementsByTagName('td');

            // Deve contenere precisamente le colonne che voglio io
            if (($tds->length != 9) &&
                ($tds->length != 7)
            ) {
                // Log::error($url);
                Log::error('Parser: Error (length ' . $tds->length . ')');

                return false;
            }

            // Verifico che il match si sia disputato
            $risultato = $this->cleanString($tds[3]->textContent);
            if (!strlen($risultato)) {
                // Log::info($url);
                Log::info('Parser: Match senza risultati ' . $tds[1]->textContent . ' - ' . $tds[2]->textContent);

                continue;
            }

            $setWon = explode("-", $this->cleanString($tds[3]->textContent));
            $result = [
                "date" => $this->cleanString($tds[0]->textContent),
                "team" => [$tds[1]->textContent, $tds[2]->textContent],
                "set_won" => $setWon,
                "set_lost" => array_reverse($setWon),
                "set_1" => $this->getPointsForSet($tds[4]->textContent),
                "set_2" => $this->getPointsForSet($tds[5]->textContent),
                "set_3" => $this->getPointsForSet($tds[6]->textContent),
                "score" => $this->getScore($setWon),
                "winner" => $this->getWinner($setWon),
            ];
            if ($tds->length == 9) {
                $result += [
                    "set_4" => $this->getPointsForSet($tds[7]->textContent),
                    "set_5" => $this->getPointsForSet($tds[8]->textContent),
                ];
            } else {
                $result += [
                    "set_4" => [null, null],
                    "set_5" => [null, null],
                ];
            }

            array_push($array, $result);

            Log::info('Parser: Trovato nuovo match ' . $result["team"][0] . " - " . $result["team"][1] . " " . $result["set_won"][0] . " - " . $result["set_won"][1]);
        }

        return $array;
    }
}
