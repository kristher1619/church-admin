<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Visitor extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Visitor::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'fullName';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'first_name','last_name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Full name', 'fullName')->onlyOnIndex()->showOnPreview(),
            Text::make('First name', 'first_name')->hideFromIndex()->rules('required'),
            Text::make('Middle name', 'middle_name')->hideFromIndex(),
            Text::make('Last name', 'last_name')->hideFromIndex()->sortable()->rules('required'),
            Select::make('Gender', 'sex')->options([
                'Male' => 'Male',
                'Female' => 'Female'
            ])->sortable()->rules('required'),
            Text::make('Church', 'church'),
            Text::make('Phone', 'phone')->onlyOnForms(),
            URL::make('Phone', fn()=> 'tel:' . $this->phone)->displayUsing(fn()=>$this->phone),

            Date::make('Date of Visit', 'date_of_visit')->displayUsing(function (?Carbon $date) {
                return $date?->format('F d, Y').', '.$date?->setYear(now()->year)?->format('l');
            })->sortable()->default(fn() => now()),

            Text::make('Date created', 'created_at')->displayUsing(function (?Carbon $date) {
                return $date?->format('F d, Y');
            })->sortable()->default(fn() => now())->exceptOnForms(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
