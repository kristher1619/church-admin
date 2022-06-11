<?php

namespace App\Nova\Members;

use App\Enums\DonationTypeEnum;
use App\Enums\MembershipStatusEnum;
use App\Nova\Actions\ImportMemberActions;
use App\Nova\Donations\Donations;
use App\Nova\Members\Filters\BirthdaysFilter;
use App\Nova\Members\Filters\MembershipStatusFilter;
use App\Nova\Members\Lenses\ThisWeekBirthday;
use App\Nova\Members\Metrics\BirthdaysPerMonth;
use App\Nova\Members\Metrics\MembersPerStatus;
use App\Nova\Members\Metrics\NewMembersPerMonth;
use App\Nova\Metrics\DonationsMetric;
use App\Nova\Resource;
use Causelabs\ResourceIndexLink\ResourceIndexLink;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\URL;
use Pdewit\ExternalUrl\ExternalUrl;

class Members extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Member::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'fullName';
    public static int $priority = 1;
    public static $group = 'Manage';
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'last_name'
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
            ID::make(__('ID'), 'id')->hideFromIndex(),
            Avatar::make('Photo', 'photo')->disableDownload()->disk('public'),
            Text::make('Full name', 'fullName')->onlyOnIndex()->showOnPreview(),
            Text::make('First name', 'first_name')->hideFromIndex()->rules('required'),
            Text::make('Middle name', 'middle_name')->hideFromIndex(),
            Text::make('Last name', 'last_name')->hideFromIndex()->sortable()->rules('required'),
            Date::make('Date of Birth', 'dob')->displayUsing(function (?Carbon $dob) {
                return $dob?->format('F d, Y') . ', ' . $dob?->setYear(now()->year)?->format('l');
            })->sortable()->rules('required'),
            Date::make('Date of Baptism', 'date_of_baptism'),
            Select::make('Membership Status', 'membership_status')->options(MembershipStatusEnum::values())->sortable(),
            Select::make('Gender', 'sex')->options([
                'Male' => 'Male',
                'Female' => 'Female'
            ])->sortable()->rules('required'),
            File::make('Baptismal Certificate', 'baptismal_certificate')->nullable()->hideFromIndex(),
            BelongsTo::make('Father', 'father', Members::class)->hideFromIndex()->nullable()->searchable()
                ->rules('different:mother')->withoutTrashed()->showCreateRelationButton()
            ,
            BelongsTo::make('Mother', 'mother', Members::class)->hideFromIndex()->nullable()->searchable()
                ->rules('different:father')->withoutTrashed()->showCreateRelationButton(),
            URL::make('Phone', fn()=> 'tel:' . $this->personal_information?->phone)->displayUsing(fn()=>$this->personal_information?->phone),

            Textarea::make('Notes', 'notes')->hideFromIndex()->alwaysShow(),

            Text::make('YTD Tithe Donations')->resolveUsing(fn() => env('CURRENCY') . number_format($this->donations()->tithe()->yearToDate()->sum('amount'), 2))->onlyOnDetail(),
            Text::make('10%')->resolveUsing(fn() => env('CURRENCY') . number_format($this->donations()->tithe()->yearToDate()->sum('amount') * .10, 2))->onlyOnDetail(),
            HasOne::make("Personal Information", 'personal_information', MemberPersonalInformationResource::class),
            HasMany::make("Donations", 'donations', Donations::class)
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
            NewMembersPerMonth::make(),
            BirthdaysPerMonth::make(),
            MembersPerStatus::make(),
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
            BirthdaysFilter::make(),
            MembershipStatusFilter::make()
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
        return [ThisWeekBirthday::make()];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            ImportMemberActions::make()->standalone()
        ];
    }
}
