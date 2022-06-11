<?php

namespace App\Enums;

trait HasValuesTrait
{

    public static function values(): array
    {
        $data=[];
        foreach (self::cases() as $case) {
            $data[$case->value] =$case->value;
        }
        return $data;
    }
}
