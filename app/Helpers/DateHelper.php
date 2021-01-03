<?php

namespace App\Helpers;

use App\Exceptions\UnexpectedDateRangeException;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;

class DateHelper
{
    /**
     * Compute a range between two dates, and generate
     * a plain array of Carbon objects of each day in it.
     *
     * @param Carbon $from
     * @param Carbon $to
     * @param bool $inclusive
     * @return array
     * @throws UnexpectedDateRangeException
     */
    public static function getDatesBetween(Carbon $from, Carbon $to, $inclusive = true): array
    {
        if ($from->gt($to)) {
            throw new UnexpectedDateRangeException();
        }

        // Clone the date objects to avoid issues, then reset their time
        /** @var Carbon $from */
        $from = $from->copy()->startOfDay();
        /** @var Carbon $to */
        $to = $to->copy()->startOfDay();

        // Include the end date in the range
        if ($inclusive) {
            $to->addDay();
        }

        $step = CarbonInterval::day();
        $period = new DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $day) {
            $range[] = new Carbon($day);
        }

        if (empty($range)) {
            throw new UnexpectedDateRangeException();
        }

        return $range;
    }
}
