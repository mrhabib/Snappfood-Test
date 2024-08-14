<?php

namespace App\Http\Controllers;

use App\Services\VendorService;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function getDelayedOrdersReport()
    {
        return VendorService::getDelayedOrdersReport();
    }
}
