<?php

namespace Imojie\Models;

use Carbon\Carbon;

class Zodiac
{
    protected $carbon;

    protected $zodiac = [
        1 => '鼠',
        2 => '牛',
        3 => '虎',
        4 => '兔',
        5 => '龙',
        6 => '蛇',
        7 => '马',
        8 => '羊',
        9 => '猴',
        10 => '鸡',
        11 => '狗',
        12 => '猪',
    ];


    protected $constellations = [
        '水瓶座' => [1.20, 2.18],
        '双鱼座' => [2.19, 3.20],
        '白羊座' => [3.21, 4.19],
        '金牛座' => [4.20, 5.20],
        '双子座' => [5.21, 6.21],
        '巨蟹座' => [6.22, 7.22],
        '狮子座' => [7.23, 8.22],
        '处女座' => [8.23, 9.22],
        '天秤座' => [9.23, 10.23],
        '天蝎座' => [10.24, 11.22],
        '射手座' => [11.23, 12.21],
        '摩羯座' => [12.22, 1.19],
    ];


    protected $constellationsMap = [
        1 => '水瓶座',
        2 => '双鱼座',
        3 => '白羊座',
        4 => '金牛座',
        5 => '双子座',
        6 => '巨蟹座',
        7 => '狮子座',
        8 => '处女座',
        9 => '天秤座',
        10 => '天蝎座',
        11 => '射手座',
        12 => '摩羯座',
    ];


    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }


    /**
     * 获取生肖
     */
    public function getZodiac()
    {
        $year = $this->carbon->year;
        return $this->zodiac[($year - 4) % 12 + 1];
    }


    public function getZodiacCode($zodiac)
    {
        $code = array_search($zodiac, $this->zodiac);
        return $code ? $code : 0;
    }


    /**
     * 获取星座
     */
    public function getConstellation()
    {
        $constellations = $this->constellations;
        unset($constellations['摩羯座']);

        $datetime = $this->carbon->month + ($this->carbon->day / 100);

        foreach ($constellations as $constellation => $section) {
            list($start, $end) = $section;
            if ($datetime >= $start && $datetime <= $end) {
                return $constellation;
            }
        }

        return '摩羯座';
    }


    public function getConstellationCode($constellation)
    {
        $code = array_search($constellation, $this->constellationsMap);
        return $code ? $code : 0;
    }


    /**
     * 获取年龄
     */
    public function getAge()
    {
        $now = Carbon::now();
        $age = $now->year - $this->carbon->year;
        return $age > 0 ? $age : 0;
    }
}