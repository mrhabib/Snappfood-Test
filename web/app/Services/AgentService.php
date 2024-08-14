<?php

namespace App\Services;

use App\DTOs\ResponseDTO;
use App\Enums\DelayedOrderStatus;
use App\Models\Agent;
use App\Models\DelayedOrder;
use Illuminate\Support\Facades\DB;

class AgentService
{
    public function assignDelayOrder(Agent $agent): ResponseDTO
    {
        if ($agent->haveActiveDelayedOrder()) {
            return ResponseDTO::create('You Already Have An Assigned Delayed Order', 422);
        }

        $delayedOrder = null;

        // in assigning delay order to each agent must handle race condition
        DB::transaction(function () use ($agent, &$delayedOrder) {
            $delayedOrder = DelayedOrder::where('status', DelayedOrderStatus::WITHOUT_OWNER->value)->orderBy('id', 'asc')->lockForUpdate()->first();

            if (!$delayedOrder) {
                return ResponseDTO::create('No delayed orders available.', 422);
            }

            $delayedOrder->update(['agent_id' => $agent->id, 'status' => DelayedOrderStatus::ASSIGNED->value]);

        });

        return ResponseDTO::create('Delayed order assigned successfully.', 200, $delayedOrder->toArray());
    }

    public function resolveOrder(Agent $agent): ResponseDTO
    {
        if (!$agent->haveActiveDelayedOrder()) {
            return ResponseDTO::create('Agent has no open delayed order.', 422);
        }

        $delayedOrder = DelayedOrder::findByAgentId($agent->id);

        if (!$delayedOrder || $delayedOrder->status != DelayedOrderStatus::ASSIGNED) {
            return ResponseDTO::create('Delayed order cannot be resolved or is already resolved.', 422);
        }

        // Update the delayed order status and mark it as done
        $delayedOrder->update(['status' => DelayedOrderStatus::Done->value, 'resolved_at' => now(),]);

        return ResponseDTO::create('Delayed order resolved successfully.');
    }

}
