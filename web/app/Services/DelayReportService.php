<?php

namespace App\Services;

use App\DTOs\ResponseDTO;
use App\Models\DelayedOrder;
use App\Models\DelayReport;
use App\Models\Order;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class DelayReportService
{

    public function reportDelay(Order $order): ResponseDTO
    {
        //check delivery time in first step
        if($order->delivery_time > $order->created_at->diffInMinutes(now())){
            return  ResponseDTO::create('Order is not delayed' , 422);
        }
        $trip = Trip::findTripByOrder($order->id);
        if($trip){
            $this->createDelayReport($order , true);
            return  ResponseDTO::create('Order Estimation has been updated');
        }
        $this->createDelayReport($order);
        return  ResponseDTO::create('Order has been reported as delayed');
    }

    public function createDelayReport(Order $order , $exist = false): void
    {
        if($exist){
            DelayReport::create([
                    'order_id' => $order->id,
                    'time'     => EstimationService::getStimate()
                ]
            );
        }
        else{
            DB::beginTransaction();
            try {
                $orderInMinutes = $order->created_at->diffInMinutes(now());
                $delay = $orderInMinutes - $order->delivery_time;
                DelayReport::create([
                        'order_id' => $order->id,
                        'time'     => $delay
                    ]
                );
                // must use redis to handle queues of delayed order
                DelayedOrder::create([
                    'order_id' => $order->id
                ]);
                DB::commit();
            } catch (\Exception $e){
                DB::rollBack();
                // can log exception to report it. or handle error
            }

        }

    }
}
