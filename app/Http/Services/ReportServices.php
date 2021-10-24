<?php

namespace App\Http\Services;

use App\Models\Entry;

trait ReportServices
{
    public function  getTotalIncomeService($request)
    {
        $data["total"] = Entry::getIncome();
        $data["today_income"] = Entry::getIncomeToday();
        return response()->json($data, 200);
    }
    public function getIncomeByDateService($request, $from_date, $to_date)
    {
        $data["total_income"] = Entry::getIncome($from_date, $to_date);
        $data["total_entry"] = Entry::getEntry($from_date, $to_date);
        $data["query"] = "displaying data between " . $from_date . " and " . $to_date;
        return response()->json($data, 200);
    }
    public function getCarReportService($request, $car_number)
    {
        $query = Entry::where(["car_number" => $car_number]);
        $data["records"] = $query->orderByDesc("id")->get();
        $data["count"] = $data["records"]->count();
        if ($data["count"] == 0) {
            return response()->json(["message" => "No report found for the given data"], 404);
        }
        $data["bills"] = $query->sum("bill");
        return response()->json($data, 200);
    }
}
