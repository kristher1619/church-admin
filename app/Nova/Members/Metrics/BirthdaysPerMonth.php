<?php

namespace App\Nova\Members\Metrics;

use App\Models\Member;
use Illuminate\Support\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class BirthdaysPerMonth extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $dobs = Member::selectRaw('extract(month from "dob") as month, count(*) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('total', 'month')->mapWithKeys(function($item, $key){
                return [Carbon::create(month: $key)->monthName=>$item];
            });

        return (new TrendResult())->trend($dobs->toArray());
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [

        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'birthdays-per-month';
    }
}
