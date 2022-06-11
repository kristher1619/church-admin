<?php

namespace App\Models;

use App\Enums\DonationTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
