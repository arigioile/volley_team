<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Models\Season;

class SeasonTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        Season::create(['name' => 'Anno 2021/22']);
        Season::create(['name' => 'Anno 2022/23']);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_active()
    {
        $this->assertEquals(Season::active(), null);

        $season = Season::find(1);

        $season->setActive();
        $this->assertEquals(Season::active()->id, 1);
    }

    public function test_isActive()
    {
        $season = Season::find(1);
        $season_other = Season::find(2);
        $season->setActive();

        $this->assertTrue($season->is_active);
        $this->assertFalse($season_other->is_active);
    }
}
