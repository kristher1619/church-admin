<?php

namespace App\Nova\Donations;

use App\Enums\DonationTypeEnum;
use App\Nova\Donations\Filters\DonationTypeFilter;
use App\Nova\Donations\Metrics\TenthTotalTitheDonations;
use App\Nova\Donations\Metrics\TotalTitheDonations;
use App\Nova\Donations\Metrics\TotalTitheDonationsValue;
use App\Nova\Members\Members;
use App\Nova\Metrics\DonationsMetric;
use App\Nova\Resource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Donations extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Donation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static int $priority = 2;
    public static $group = 'Manage';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'amount'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable()->hideFromIndex(),

            BelongsTo::make("Member", 'member', Members::class)->withoutTrashed()->searchable(),
            Date::make("Donation Date", 'date')->displayUsing(fn(Carbon $value) => $value->format('F d, Y'))->default(fn() => now()->startOfWeek(Carbon::SUNDAY))->rules(['required'])->sortable(),
            Select::make("Classification", 'type')->options(DonationTypeEnum::values())->sortable()->sortable()->default(fn() => DonationTypeEnum::Tithe->value),
            Number::make("Amount", 'amount')->displayUsing(fn($value) => env('CURRENCY') . number_format($value, 2))->rules(['required', 'int'])->sortable()->step(0.1)->min(1),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
//            TotalDonations::make(),
            TotalTitheDonationsValue::make(),
            TotalTitheDonations::make(),
//            TenthTotalTitheDonations::make(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            DonationTypeFilter::make()
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];
            return $query->orderBy('date', 'desc');
        }
        return $query;
    }
}
