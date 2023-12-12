<?php

namespace Instrument;

use Carbon\Carbon;

trait InteractsWithReport
{
    public function scopeMonthsOfYear($query, $field)
    {
        $now = now();
        $year = request('year', $now->year);

        $financialStart = $this->getFinancialStart($year);

        // Check if FS has been customized
        if ($now->startOfYear()->format('Y-m-d') === $financialStart->format('Y-m-d')) {
            $start = Carbon::parse($year . '-01-01')->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($year . '-12-31')->endOfDay()->format('Y-m-d H:i:s');
        } else {
            $start = $financialStart
                    ->startOfDay()
                    ->format('Y-m-d H:i:s');
            $end = $financialStart
                    ->addYear(1)
                    ->subDays(1)
                    ->endOfDay()
                    ->format('Y-m-d H:i:s');
        }

        return $query->whereBetween($field, [$start, $end]);
    }

    /**
     * Get the financial start date.
     *
     * @param mixed $year
     * @return \Carbon\Carbon|false
     */
    public function getFinancialStart($year = null)
    {
        $now = now();
        $start = now()->startOfYear();

        $setting = explode('-', auth()->user()->currentTeam->reportSettings()->financial_start);

        $day = ! empty($setting[0]) ? $setting[0] : $start->day;
        $month = ! empty($setting[1]) ? $setting[1] : $start->month;
        $year = $year ?? request('year', $now->year);

        $financialStart = Carbon::create($year, $month, $day);

        if ((auth()->user()->currentTeam->reportSettings()->financial_year == 'ends') && ($financialStart->dayOfYear != 1)) {
            $financialStart->subYear();
        }

        return $financialStart;
    }
}
