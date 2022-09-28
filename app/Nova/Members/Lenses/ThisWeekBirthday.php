<?php

namespace App\Nova\Members\Lenses;

use Causelabs\ResourceIndexLink\ResourceIndexLink;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Lenses\Lens;

class ThisWeekBirthday extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        $rawDob = DB::raw(sprintf("TO_CHAR(dob :: DATE, '%s-MM-dd')", now()->year));

        return $request->withOrdering($request->withFilters(
            $query->where($rawDob, '>=', now()->startOfWeek(Carbon::SUNDAY)->toDateTimeString())
                ->where($rawDob, '<=', now()->endOfWeek(Carbon::SATURDAY)->toDateTimeString())
            ->orderByRaw('extract(day from dob)')
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Avatar::make('Photo', 'photo')->disableDownload(),
            Text::make('Full name', 'last_name')->resolveUsing(fn() => $this->fullName)->sortable()->onlyOnIndex(),
            Date::make('Date of Birth', 'dob')->resolveUsing(function(?Carbon $dob){
                return $dob?->format('F d, Y');
            })->rules('required'),
            Text::make("Day")->resolveUsing(function() {
                return  $this->dob?->setYear(now()->year)?->format('l');
            }),
            Text::make("Age")->resolveUsing(function() {
                return  now()->endOfYear()->diffInYears($this->dob );
            })

        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'this-month-birthday';
    }

    public function name()
    {
       return "This Week's Birthday";
    }
}
