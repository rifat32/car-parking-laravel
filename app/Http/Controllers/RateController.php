<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Http\Services\RateServices;
use Illuminate\Http\Request;

class RateController extends Controller
{
    use RateServices;
    public function getRate(Request $request)
    {
        return $this->getRateService($request);
    }
    public function updateRate(RateRequest $request)
    {
        return $this->updateRateService($request);
    }
}
