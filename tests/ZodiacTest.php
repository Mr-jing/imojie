<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use Imojie\Models\Zodiac;

class ZodiacTest extends TestCase
{

    public function ageProvider()
    {
        return array(
            array('1992-07-26', 23),
            array('1992-08-24', 23),
            array('1968-02-08', 47),
            array('1969-11-20', 46),
            array('2015-01-01', 0),
        );
    }


    /**
     * @dataProvider ageProvider
     */
    public function testGetAge($date, $age)
    {
        $zodiac = new Zodiac(new Carbon($date));
        $this->assertSame($age, $zodiac->getAge());
    }


    public function zodiacProvider()
    {
        return array(
            array('1992-07-26', '猴'),
            array('1992-08-24', '猴'),
            array('1968-02-08', '猴'),
            array('1969-11-20', '鸡'),
            array('2015-01-01', '羊'),
        );
    }


    /**
     * @dataProvider zodiacProvider
     */
    public function testGetZodiac($date, $animal)
    {
        $zodiac = new Zodiac(new Carbon($date));
        $this->assertSame($animal, $zodiac->getZodiac());
    }


    public function constellationProvider()
    {
        return array(
            array('1992-07-26', '狮子座'),
            array('1992-08-24', '处女座'),
            array('1968-02-08', '水瓶座'),
            array('1969-11-20', '天蝎座'),
            array('2015-01-01', '摩羯座'),
        );
    }


    /**
     * @dataProvider constellationProvider
     */
    public function testGetConstellation($date, $constellation)
    {
        $zodiac = new Zodiac(new Carbon($date));
        $this->assertSame($constellation, $zodiac->getConstellation());
    }
}
