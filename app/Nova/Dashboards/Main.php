<?php

namespace App\Nova\Dashboards;

use App\Nova\Donations\Metrics\TotalTitheDonations;
use App\Nova\Donations\Metrics\TotalTitheDonationsValue;
use App\Nova\Members\Lenses\ThisWeekBirthday;
use App\Nova\Members\Metrics\BirthdaysPerMonth;
use App\Nova\Members\Metrics\MembersPerStatus;
use App\Nova\Members\Metrics\NewMembersPerMonth;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function name()
    {
        return "Dashboard";
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            NewMembersPerMonth::make(),
            MembersPerStatus::make(),
            TotalTitheDonationsValue::make(),
            TotalTitheDonations::make(),
            BirthdaysPerMonth::make(),
        ];
    }
}
