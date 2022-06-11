<?php

namespace App\Models;

use App\Models\Traits\HasFullName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory, HasFullName;
    protected $casts=[
        'date_of_visit'=>'datetime'
    ];
}
