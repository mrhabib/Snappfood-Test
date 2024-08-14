<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'order_number',
        'status',
        'delivery_time',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function trip(): HasOne
    {
        return $this->hasOne(Trip::class);
    }

    public function delayReports(): HasMany
    {
        return $this->hasMany(DelayReport::class);
    }

}
