<?php

namespace App\Services;

use App\Http\Resources\VendorDelayOrderReportResource;
use App\Models\Agent;
use App\Models\DelayedOrder;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class VendorService
{
    public static function getDelayedOrdersReport()
    {
        $vendors =  Vendor::has('delays')->withCount(['delays as total_delay_time' => function ($query) {
            $query->select(DB::raw('SUM(time)'));
        }])
            ->orderBy('total_delay_time','desc')
            ->get();
        return VendorDelayOrderReportResource::collection($vendors);
    }
}
