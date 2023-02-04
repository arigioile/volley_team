<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Models\Setting;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test dei get e set.
     *
     * @return void
     */
    public function test_setAndGet()
    {
        Setting::setValueForKey('prova', '11');
        $this->assertEquals(Setting::valueForKey('prova'), 11);

        Setting::setValueForKey('prova', '22');
        $this->assertNotEquals(Setting::valueForKey('prova'), 11);
        $this->assertEquals(Setting::valueForKey('prova'), 22);

        $this->assertEquals(Setting::valueForKey('non esiste'), null);
        $this->assertEquals(Setting::valueForKey('non esiste', 33), 33);
        $this->assertEquals(Setting::valueForKey('non esiste', 'lo stesso'), 'lo stesso');
        $this->assertNotEquals(Setting::valueForKey('non esiste', 'null'), null);
    }
}
