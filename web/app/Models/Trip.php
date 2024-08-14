<?php

namespace App\Models;

use App\Enums\TripStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status'
    ];
    protected $casts = [
        'status' => TripStatus::class
    ];

    public function setStatusAttribute( $value): void
    {
        if (!in_array($value, TripStatus::cases())) {
            throw new InvalidArgumentException("Invalid status");
        }
        $this->attributes['status'] = $value;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function findTripByOrder($orderId)
    {
        return self::whereIn('status', [
            TripStatus::AT_VENDOR->value,
            TripStatus::PICKED->value,
            TripStatus::ASSIGNED->value,
        ])
            ->where('order_id', $orderId)
            ->first();
    }
}
