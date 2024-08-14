<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class DelayReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'time',
        'created_at',
        'updated_at'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function vendor(): HasOneThrough
    {
        return $this->hasOneThrough(Vendor::class, Order::class);
    }
}
