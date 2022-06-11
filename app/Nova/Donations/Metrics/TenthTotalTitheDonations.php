<?php

namespace App\Nova\Donations\Metrics;

use App\Models\Donation;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class TenthTotalTitheDonations extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->sum($request, Donation::tithe(), 'month', 'amount', 'date')->showSumValue()->prefix(env('CURRENCY'))->format('0,000,00');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            1 => __('1 Month'),
            3 => __('3 Months'),
            6 => __('6 Months'),
            12 => __('12 Months'),
            now()->month => __('Year to Date'),
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
        return 'total-tenth-tithe-donations';
    }

}
