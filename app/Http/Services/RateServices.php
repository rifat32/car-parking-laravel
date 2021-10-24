<?php

namespace App\Http\Services;

use App\Models\Rate;

trait RateServices
{
    public function getRateService($request)
    {
        $rate = Rate::first();
        if (!$rate) {
            return response()->json([
                "message" => "No data found"
            ], 404);
        }

        return response()->json([
            "rate" => $rate
        ], 200);
    }
    public function updateRateService($request)
    {
        $rate = Rate::first();
        if ($rate) {
            $rate->rate = (int) $request->rate;
            $rate->save();
        } else {
            $newRate = new Rate();
            $newRate->rate = (int) $request->rate;
            $newRate->save();
        }
        return response()->json(["ok" => true]);
    }
}
