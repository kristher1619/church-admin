<?php

namespace App\Models;

use App\Enums\DonationTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Donation
 *
 * @property int $id
 * @property int|null $member_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon $date
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member|null $member
 * @method static \Database\Factories\DonationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation tithe()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation yearToDate()
 * @mixin \Eloquent
 */
class Donation extends Model {
    protected $with = ['member'];
    use HasFactory;

    protected $casts = ['date' => 'date'];

    public function member(): BelongsTo {
        return $this->belongsTo(Member::class);
    }

    public function scopeTithe($query) {
        $query->where('type', '>=', DonationTypeEnum::Tithe->value);
    }

    public function scopeYearToDate($query) {
        $query->where('date', '>=', now()->startOfYear());
    }
}
