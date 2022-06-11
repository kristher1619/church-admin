<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MemberPersonalInformation
 *
 * @property int $id
 * @property int|null $member_id
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $postcode
 * @property string|null $phone
 * @property string|null $phone_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member|null $member
 * @method static \Database\Factories\MemberPersonalInformationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation wherePhoneType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPersonalInformation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberPersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = ['address_line_1', 'address_line_2', 'city', 'stat', 'country', 'postcode', 'phone', 'phone_type'];

    public function member(): BelongsTo
    {
       return $this->belongsTo(Member::class) ;
    }
}
