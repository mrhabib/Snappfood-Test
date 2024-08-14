<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DelayReportController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\VendorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('orders/{order}/delay',[DelayReportController::class,'reportDelay'])->name('order.report-delay');
Route::get('agents/{agent}/assign-delay-order',[AgentController::class,'assignDelayOrder'])->name('agent.assign-delay-order');
Route::get('agents/{agent}/resolve-order', [AgentController::class, 'resolveOrder'])->name('agent.resolve-order');
Route::get('vendors/get-delayed-orders-report',[VendorController::class,'getDelayedOrdersReport'])->name('vendors.get-delayed-orders-report');

