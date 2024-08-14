<?php

namespace App\Models;

use App\Enums\DelayedOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DelayedOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'order_id',
        'status',
    ];

    protected $casts = [
        'status' => DelayedOrderStatus::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public static function findByAgentId(int $agentId): ?self
    {
        return self::where([['agent_id', $agentId], ['status',DelayedOrderStatus::ASSIGNED->value]])->first();
    }
}
