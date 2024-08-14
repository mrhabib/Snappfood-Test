<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Services\AgentService;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgentController extends Controller
{

    public function __construct(protected AgentService  $agentService)
    {

    }
    public function assignDelayOrder(Agent $agent): JsonResponse
    {
        $response = $this->agentService->assignDelayOrder($agent);
        if($response->getStatus() == 200)
            return ResponseService::success($response->getData(),$response->getMessage());

        return ResponseService::error($response->getData(), $response->getMessage(), $response->getStatus());
    }

    public function resolveOrder(Agent $agent): JsonResponse
    {
        $response = $this->agentService->resolveOrder($agent);
        if($response->getStatus() == 200)
            return ResponseService::success($response->getData(),$response->getMessage());

        return ResponseService::error($response->getData(), $response->getMessage(), $response->getStatus());
    }
}
