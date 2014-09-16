<?php

namespace Holiday;

/**
 * Class HolidayCalculator
 *
 * @author Brian Feaver <brian.feaver@gmail.com>
 */
class HolidayCalculator
{
    /**
     * @param \DateTime $date
     * @return bool
     */
    public function isHoliday(\DateTime $date)
    {
        $formattedList = array_map(
            function (\DateTime $date) {
                return $date->format('Y-m-d');
            },
            $this->getHolidayList($date->format('Y'))
        );

        return in_array($date->format('Y-m-d'), $formattedList);
    }

    /**
     * Returns an array of holidays for the given year.
     *
     * @param int|string $year
     * @return \DateTime[]
     */
    public function getHolidayList($year)
    {
        return [
            $this->adjustFixedHoliday(new \DateTime("$year-01-01 00:00:00")), // New Year's
            new \DateTime("3 Mondays after $year-01-01 00:00:00"),            // MLK Birthday
            new \DateTime("3 Mondays after $year-02-01 00:00:00"),            // Washington's Birthday
            new \DateTime("last Monday of May $year"),                        // Memorial Day
            $this->adjustFixedHoliday(new \DateTime("$year-07-04 00:00:00")), // Independence Day
            new \DateTime("first Monday of September $year"),                 // Labor Day
            new \DateTime("2 Mondays after $year-10-01 00:00:00"),            // Columbus Day
            $this->adjustFixedHoliday(new \DateTime("$year-11-11 00:00:00")), // Veteran's Day
            new \DateTime("4 Thursdays after $year-11-01 00:00:00"),          // Thanksgiving Day
            $this->adjustFixedHoliday(new \DateTime("$year-12-25 00:00:00")), // Christmas Day
        ];
    }

    private function adjustFixedHoliday(\DateTime $holiday)
    {
        $weekday = $holiday->format('w');
        if ($weekday == 0) {
            $holiday->modify('+1 day');
        } elseif ($weekday == 6) {
            $holiday->modify('-1 day');
        }

        return $holiday;
    }
}
