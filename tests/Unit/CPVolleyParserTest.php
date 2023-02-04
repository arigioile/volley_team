<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Models\CPVolleyParser;
use Illuminate\Support\Facades\Log;

class CPVolleyParserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_isWinner()
    {
        $parser = new CPVolleyParser();

        $this->assertTrue($parser->isWinner(['3', '0'], CPVolleyParser::HOME_TEAM));

        $this->assertTrue($parser->isWinner([3, 0], CPVolleyParser::HOME_TEAM));
        $this->assertTrue($parser->isWinner([3, 1], CPVolleyParser::HOME_TEAM));
        $this->assertTrue($parser->isWinner([3, 2], CPVolleyParser::HOME_TEAM));
        $this->assertTrue($parser->isWinner([2, 0], CPVolleyParser::HOME_TEAM));
        $this->assertTrue($parser->isWinner([2, 1], CPVolleyParser::HOME_TEAM));
        $this->assertTrue($parser->isWinner([1, 0], CPVolleyParser::HOME_TEAM));

        $this->assertTrue($parser->isWinner([0, 3], CPVolleyParser::VISITOR_TEAM));
        $this->assertTrue($parser->isWinner([1, 3], CPVolleyParser::VISITOR_TEAM));
        $this->assertTrue($parser->isWinner([2, 3], CPVolleyParser::VISITOR_TEAM));
        $this->assertTrue($parser->isWinner([0, 2], CPVolleyParser::VISITOR_TEAM));
        $this->assertTrue($parser->isWinner([1, 2], CPVolleyParser::VISITOR_TEAM));
        $this->assertTrue($parser->isWinner([0, 1], CPVolleyParser::VISITOR_TEAM));

        $this->assertFalse($parser->isWinner([3, 0], CPVolleyParser::VISITOR_TEAM));
        $this->assertFalse($parser->isWinner([3, 1], CPVolleyParser::VISITOR_TEAM));
        $this->assertFalse($parser->isWinner([3, 2], CPVolleyParser::VISITOR_TEAM));
        $this->assertFalse($parser->isWinner([2, 0], CPVolleyParser::VISITOR_TEAM));
        $this->assertFalse($parser->isWinner([2, 1], CPVolleyParser::VISITOR_TEAM));
        $this->assertFalse($parser->isWinner([1, 0], CPVolleyParser::VISITOR_TEAM));

        $this->assertFalse($parser->isWinner([0, 3], CPVolleyParser::HOME_TEAM));
        $this->assertFalse($parser->isWinner([1, 3], CPVolleyParser::HOME_TEAM));
        $this->assertFalse($parser->isWinner([2, 3], CPVolleyParser::HOME_TEAM));
        $this->assertFalse($parser->isWinner([0, 2], CPVolleyParser::HOME_TEAM));
        $this->assertFalse($parser->isWinner([1, 2], CPVolleyParser::HOME_TEAM));
        $this->assertFalse($parser->isWinner([0, 1], CPVolleyParser::HOME_TEAM));
    }

    public function test_isWinner_2()
    {
        $this->assertTrue(CPVolleyParser::isWinner(['3', '0'], CPVolleyParser::HOME_TEAM));
        $this->assertTrue(CPVolleyParser::isWinner([0, 2], CPVolleyParser::VISITOR_TEAM));
    }

    public function test_getWinner()
    {
        $parser = new CPVolleyParser();

        $this->assertEquals($parser->getWinner([0, 3]), [false, true]);
        $this->assertEquals($parser->getWinner([2, 1]), [true, false]);
    }


    public function test_getScore()
    {
        $parser = new CPVolleyParser();

        // Test per partite al meglio dei 5
        $this->assertEquals($parser->getScore([0, 3]), [0, 3]);
        $this->assertEquals($parser->getScore([1, 3]), [0, 3]);
        $this->assertEquals($parser->getScore([2, 3]), [1, 2]);
        $this->assertEquals($parser->getScore([3, 0]), [3, 0]);
        $this->assertEquals($parser->getScore([3, 1]), [3, 0]);
        $this->assertEquals($parser->getScore([3, 2]), [2, 1]);

        // Test per partite al meglio dei 3
        $this->assertEquals($parser->getScore([2, 0]), [3, 0]);
        $this->assertEquals($parser->getScore([2, 1]), [2, 1]);
        $this->assertEquals($parser->getScore([0, 2]), [0, 3]);
        $this->assertEquals($parser->getScore([1, 2]), [1, 2]);
    }

    public function test_getPointsForSet()
    {
        $parser = new CPVolleyParser();

        $this->assertEquals($parser->getPointsForSet("-"), [null, null]);
        $this->assertEquals($parser->getPointsForSet(""), [null, null]);
        $this->assertEquals($parser->getPointsForSet("kshbshvfb kh"), [null, null]);
        $this->assertEquals($parser->getPointsForSet("kshbshvf-kh"), [null, null]);
        $this->assertEquals($parser->getPointsForSet("kshbshvf-1"), [null, null]);
        $this->assertEquals($parser->getPointsForSet("0-kh"), [null, null]);
        $this->assertEquals($parser->getPointsForSet("-1"), [null, null]);
        $this->assertEquals($parser->getPointsForSet("-1-2"), [null, null]);

        $this->assertEquals($parser->getPointsForSet("0-10"), [0, 10]);
        $this->assertEquals($parser->getPointsForSet("0-0"), [0, 0]);
        $this->assertEquals($parser->getPointsForSet(" 0- 0 "), [0, 0]);
        $this->assertEquals($parser->getPointsForSet("3-2"), [3, 2]);
        $this->assertEquals($parser->getPointsForSet(" 13- 25 "), [13, 25]);
        $this->assertEquals($parser->getPointsForSet(" 0- 125 "), [0, 125]);
    }

    public function test_parseRoundMatches()
    {
        $parser = new CPVolleyParser();

        $htmlText = file_get_contents('tests/Extra/file_1.html');
        $list = $parser->parseRoundMatches($htmlText);
        $atteso = [
            [
                "date" => "10/11/22",
                "team" => [
                    "Cral E. Mattei",
                    "SBT Volley Clai",
                ],
            ],
            [
                "date" => "19/01/23",
                "team" => [
                    "VBR volley Fusignano",
                    "Le Riserve",
                ],
            ],
        ];

        $this->assertEquals($list, $atteso);
    }

    public function test_parseLocationMatches()
    {
        $parser = new CPVolleyParser();
        $htmlText = file_get_contents('tests/Extra/file_2.html');
        $list = $parser->parseLocationMatches($htmlText);
        $atteso = [
            [
                "time" => "20:30",
                "location" => "Faenza",
                "gym" => "Palestra Istituto Ballardini",
                "team" => [
                    "MMB Volley Team",
                    "Oratorio Murialdo",
                ],
            ],
            [
                "time" => "21:30",
                "location" => "Ravenna",
                "gym" => "Pala Mattei",
                "team" => [
                    "Cral E. Mattei",
                    "SBT Volley Clai",
                ],
            ],
            [
                "time" => "21:45",
                "location" => "Ravenna",
                "gym" => "Pala Leo",
                "team" => [
                    "Oratorio Murialdo",
                    "Le Riserve",
                ],
            ],
        ];

        $this->assertEquals($list, $atteso);
    }

    public function test_parseResultMatches_1()
    {
        $parser = new CPVolleyParser();
        $htmlText = file_get_contents('tests/Extra/file_1.html');
        $list = $parser->parseResultMatches($htmlText);

        $atteso = [
            [
                "date" => "10/11/22",
                "team" => [
                    "Cral E. Mattei",
                    "SBT Volley Clai",
                ],
                "set_won" =>  [
                    "0",
                    "3",
                ],
                "set_lost" =>  [
                    "3",
                    "0",
                ],
                "set_1" =>  [
                    "14",
                    "25",
                ],
                "set_2" =>  [
                    "15",
                    "25",
                ],
                "set_3" =>  [
                    "22",
                    "25",
                ],
                "set_4" =>  [
                    null,
                    null,
                ],
                "set_5" =>  [
                    null,
                    null,
                ],
                "score" =>  [
                    0,
                    3,
                ],
                "winner" => [
                    false,
                    true,
                ],
            ],
        ];

        $this->assertEquals($list, $atteso);
    }

    public function test_parseResultMatches_2()
    {
        $parser = new CPVolleyParser();
        $htmlText = file_get_contents('tests/Extra/file_3.html');
        $list = $parser->parseResultMatches($htmlText);

        $atteso = [

            [
                "date" => "24/01/20",
                "team" => [
                    "P.G.S. Maccabeus Voltana",
                    "Gruppo Aura Volley Cesenatico",
                ],
                "set_won" => [
                    "1",
                    "3",
                ],
                "set_lost" => [
                    "3",
                    "1",
                ],
                "set_1" => [
                    "25",
                    "17",
                ],
                "set_2" => [
                    "23",
                    "25",
                ],
                "set_3" => [
                    "14",
                    "25",
                ],
                "set_4" => [
                    "22",
                    "25",
                ],
                "set_5" => [
                    null,
                    null,
                ],
                "score" => [
                    0,
                    3,
                ],
                "winner" => [
                    false,
                    true,
                ],
            ], [
                "date" => "24/01/20",
                "team" => [
                    "Rapid S. Bartolo",
                    "CSI Consolini",
                ],
                "set_won" => [
                    "3",
                    "0",
                ],
                "set_lost" => [
                    "0",
                    "3",
                ],
                "set_1" => [
                    "25",
                    "23",
                ],
                "set_2" => [
                    "25",
                    "23",
                ],
                "set_3" => [
                    "25",
                    "22",
                ],
                "set_4" => [
                    null,
                    null,
                ],
                "set_5" => [
                    null,
                    null,
                ],
                "score" => [
                    3,
                    0,
                ],
                "winner" => [
                    true,
                    false,
                ],
            ],
            [
                "date" => "24/01/20",
                "team" => [
                    "Val Lamone",
                    "Mespic La Sabbiona",
                ],
                "set_won" => [
                    "3",
                    "2",
                ],
                "set_lost" => [
                    "2",
                    "3",
                ],
                "set_1" => [
                    "24",
                    "26",
                ],
                "set_2" => [
                    "25",
                    "16",
                ],
                "set_3" => [
                    "25",
                    "23",
                ],
                "set_4" => [
                    "25",
                    "27",
                ],
                "set_5" => [
                    "15",
                    "9",
                ],
                "score" => [
                    2,
                    1,
                ],
                "winner" => [
                    true,
                    false,
                ],
            ],
        ];

        $this->assertEquals($list, $atteso);
    }
}
