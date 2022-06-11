<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasFullName
{
    public function fullName(): Attribute
    {
        return Attribute::make(get: fn() => "$this->last_name, $this->first_name $this->middle_name");
    }


}
