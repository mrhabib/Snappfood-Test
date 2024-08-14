<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DelayReportService;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;

class DelayReportController extends Controller
{
    public function __construct(protected DelayReportService $delayReportService)
    {

    }

    public function reportDelay(Order $order): JsonResponse
    {
        $response = $this->delayReportService->reportDelay($order);

        if ($response->getStatus() == 200) {
            return ResponseService::success($response->getData(), $response->getMessage());
        }

        return ResponseService::error($response->getData(), $response->getMessage(), $response->getStatus());
    }
}
