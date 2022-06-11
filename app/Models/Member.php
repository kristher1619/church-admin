<?php

namespace App\Models;

use App\Models\Traits\HasFullName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Member
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property \Illuminate\Support\Carbon $dob
 * @property \Illuminate\Support\Carbon|null $date_of_baptism
 * @property string|null $baptismal_certificate
 * @property string|null $photo
 * @property string|null $membership_status
 * @property string|null $notes
 * @property string|null $sex
 * @property string|null $date_died
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $father_id
 * @property int|null $mother_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Donation[] $donations
 * @property-read int|null $donations_count
 * @property-read Member|null $father
 * @property-read Member|null $mother
 * @property-read \App\Models\MemberPersonalInformation|null $personal_information
 * @method static \Database\Factories\MemberFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newQuery()
 * @method static \Illuminate\Database\Query\Builder|Member onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereBaptismalCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDateDied($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDateOfBaptism($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereFatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMembershipStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMotherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Member withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Member withoutTrashed()
 * @mixin \Eloquent
 */
class Member extends Model
{
    use HasFactory, SoftDeletes, HasFullName;

    protected $fillable = [
        'first_name', 'last_name', 'middle_name', 'dob', 'date_of_baptism', 'membership_status', 'sex', 'date_died'
    ];

    protected $with = ['personal_information'];
    protected $casts = [
        'dob' => 'date',
        'date_of_baptism' => 'date'
    ];

    public function father(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'father_id', 'id');
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mother_id', 'id');
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
