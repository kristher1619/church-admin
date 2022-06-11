<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts=[
        'dob'=>'date',
        'date_of_baptism'=>'date'
    ];

    public function fullName(): Attribute
    {
        return Attribute::make(get: fn()=> "$this->last_name, $this->first_name $this->middle_name");
    }

    public function father(): BelongsTo
    {
       return $this->belongsTo(Member::class, 'father_id','id') ;
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mother_id','id') ;
    }

    public function donations(): HasMany
    {
       return $this->hasMany(Donation::class);
    }

    public function personal_information(): HasOne
    {
        return $this->hasOne(MemberPersonalInformation::class);
    }
}
