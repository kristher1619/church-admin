<?php

namespace App\Nova\Members;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class MemberPersonalInformationResource extends Resource
{
    public static $displayInNavigation = false;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MemberPersonalInformation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable()->hide(),
            BelongsTo::make('Member', 'member', Members::class),
            Text::make('Address line 1', 'address_line_1')->nullable()->placeholder('House #, Street'),
            Text::make('Address line 2', 'address_line_2')->nullable()->placeholder('Barangay or Sub-division'),
            Text::make('City', 'city')->nullable(),
            Text::make('State/Province', 'state')->nullable(),
            Text::make('Country', 'country')->nullable(),
            Text::make('Postcode', 'postcode')->nullable()->default('2400'),
            Text::make('Phone', 'phone')->nullable(),
            Select::make('Phone Type', 'phone_type')->nullable()->options(['Mobile'=>'Mobile','Office'=>'Office', 'Home'=>'Home', 'Other'=>'Other'])->default(fn()=>'Mobile'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }


}
