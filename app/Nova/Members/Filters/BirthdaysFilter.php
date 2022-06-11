<?php

namespace App\Nova\Members\Filters;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\Filter;

class BirthdaysFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $rawDob = DB::raw(sprintf("TO_CHAR(dob :: DATE, '%s-MM-dd')", now()->year));

        $newQuery = $query;
        if ($value === 'this-week') {
            $newQuery = $query->where($rawDob, '>=', now()->startOfWeek(Carbon::SUNDAY)->toDateTimeString())
                ->where($rawDob, '<=', now()->endOfWeek(Carbon::SATURDAY)->toDateTimeString());
        }

        if ($value === 'next-week') {
            $newQuery = $query->where($rawDob, '>=', now()->addWeek()->startOfWeek(Carbon::SUNDAY)->toDateTimeString())
                ->where($rawDob, '<=', now()->addWeek()->endOfWeek(Carbon::SATURDAY)->toDateTimeString());
        }

        if ($value === 'this-month') {
            $newQuery = $query->where(\DB::raw('extract(month from dob)'), '=', now()->month);
        }

        if ($value === 'next-month') {
            $newQuery = $query->where(\DB::raw('extract(month from dob)'), '=', now()->addMonth(1)->month);
        }
        return $newQuery->orderByRaw("TO_CHAR(dob :: DATE, 'MM-dd')");
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'This Week' => 'this-week',
            'Next Week' => 'next-week',
            'This Month' => 'this-month',
            'Next Month' => 'next-month',
        ];
    }

    public function name()
    {
        return 'Birthdays';
    }
}
