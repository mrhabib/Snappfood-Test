<?php

namespace App\Services;

class EstimationService
{

    public static function getStimate()
    {
        if (config('services.estimation.isMockMode'))
            return random_int(10, 50);
        else {
            // get data from External API calculate time
        }
    }

}
