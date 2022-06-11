<?php

namespace App\Enums;

enum DonationTypeEnum: string
{
    use HasValuesTrait;

    case Tithe = "Tithe";
    case Pledge = "Pledge";
    case Thanksgiving = "Thanksgiving";

}
