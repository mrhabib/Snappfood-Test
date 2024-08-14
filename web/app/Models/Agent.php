<?php

namespace App\Models;

use App\Enums\DelayedOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function DelayedOrder(): HasOne
    {
        return $this->hasOne(DelayedOrder::class);
    }

    public function haveActiveDelayedOrder(): bool
    {
        return $this->delayedOrder()->where('status', DelayedOrderStatus::ASSIGNED->value)->exists();
    }
}
