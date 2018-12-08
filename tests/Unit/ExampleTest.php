<?php

namespace Tests\Unit;

use App\Helper\DateHelper;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(DateHelper::parseDate('1.01.2018'));
        $this->assertTrue(DateHelper::parseDate('1/01'));
        $this->assertTrue(DateHelper::parseDate('1 декабря'));
        $this->assertTrue(DateHelper::parseDate('7 ноября 2018'));
        $this->assertTrue(DateHelper::parseDate('23 октября 1235'));
        $this->assertTrue(DateHelper::parseDate('8 сентября'));
        $this->assertTrue(DateHelper::parseDate('3 августа'));
        $this->assertTrue(DateHelper::parseDate('3 июля'));
        $this->assertTrue(DateHelper::parseDate('9 июня 2018'));
        $this->assertTrue(DateHelper::parseDate('9 мая'));
        $this->assertTrue(DateHelper::parseDate('6 апреля'));
        $this->assertTrue(DateHelper::parseDate('23 марта'));
        $this->assertTrue(DateHelper::parseDate('9 февраля'));
        $this->assertTrue(DateHelper::parseDate('1 января'));

        $this->assertFalse(DateHelper::parseDate('1 январ'));

        $this->assertFalse(DateHelper::parseDate('j'));
        $this->assertFalse(DateHelper::parseDate('73 января'));
        $this->assertFalse(DateHelper::parseDate('2364'));
        $this->assertFalse(DateHelper::parseDate('2364'));
    }
}
