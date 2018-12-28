<?php

namespace Tests\Unit;

use App\Helper\DateHelper;
use Tests\TestCase;

class DateHelperTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertContains('01.01.2018', DateHelper::parseDate('1.01.2018'));
        $this->assertContains('01.01.2019', DateHelper::parseDate('1/01'));
        $this->assertNotFalse(DateHelper::parseDate('1 декабря'));
        $this->assertNotFalse(DateHelper::parseDate('7 ноября 2018'));
        $this->assertNotFalse(DateHelper::parseDate('23 октября 1235'));
        $this->assertNotFalse(DateHelper::parseDate('8 сентября'));
        $this->assertNotFalse(DateHelper::parseDate('3 августа'));
        $this->assertNotFalse(DateHelper::parseDate('3 июля'));
        $this->assertNotFalse(DateHelper::parseDate('9 июня 2018'));
        $this->assertNotFalse(DateHelper::parseDate('9 мая'));
        $this->assertNotFalse(DateHelper::parseDate('6 апреля'));
        $this->assertNotFalse(DateHelper::parseDate('23 марта'));
        $this->assertNotFalse(DateHelper::parseDate('9 февраля'));
        $this->assertNotFalse(DateHelper::parseDate('1 января'));
        $this->assertNotFalse(DateHelper::parseDate('1.12'));
        $this->assertNotFalse(DateHelper::parseDate('2364'));
        $this->assertNotFalse(DateHelper::parseDate('01/12'));

        $this->assertFalse(DateHelper::parseDate('1 январ'));
        $this->assertFalse(DateHelper::parseDate('j'));
        $this->assertFalse(DateHelper::parseDate('73 января'));
        $this->assertFalse(DateHelper::parseDate('-1 56'));
    }
}
