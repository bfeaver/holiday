<?php

class HolidayCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testHolidayListForAYear()
    {
        $calc = new \Holiday\HolidayCalculator();

        $list = $calc->getHolidayList(2014);

        $formattedList = array_map(
            function (\DateTime $date) {
                return $date->format('Y-m-d');
            },
            $list
        );
        $expectedList = [
            '2014-01-01',
            '2014-01-20',
            '2014-02-17',
            '2014-05-26',
            '2014-07-04',
            '2014-09-01',
            '2014-10-13',
            '2014-11-11',
            '2014-11-27',
            '2014-12-25',
        ];
        $this->assertEquals($expectedList, $formattedList);
    }

    public function isHolidayProvider()
    {
        return [
            'New Years Day, no time'        => [new \DateTime('2014-01-01')],
            'New Years Day w/ time'         => [new \DateTime('2014-01-01 12:00:00')],
            'New Years Day, different year' => [new \DateTime('2015-01-01 00:00:00')],
            'Independence Day, adjusted'    => [new \DateTime('2015-07-03 00:00:00')],
        ];
    }

    /**
     * @dataProvider isHolidayProvider
     */
    public function testIsHoliday($date)
    {
        $calc = new \Holiday\HolidayCalculator();

        $this->assertTrue($calc->isHoliday($date));
    }

    public function isNotHolidayProvider()
    {
        return [
            'Independence Day, not adjusted' => [new \DateTime('2015-07-04 00:00:00')],
            'Just not a holiday'             => [new \DateTime('2015-01-02 00:00:00')],
        ];
    }

    /**
     * @dataProvider isNotHolidayProvider
     */
    public function testIsNotAHoliday($date)
    {
        $calc = new \Holiday\HolidayCalculator();
        $this->assertFalse($calc->isHoliday($date));
    }
}
