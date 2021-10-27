<?php

namespace App\Http\Controllers;

use App\Http\Services\ReportServices;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ReportServices;
    public function getTotalIncome(Request $request)
    {
        return $this->getTotalIncomeService($request);
    }
    public function getIncomeByDate(Request $request, $from_date, $to_date)
    {
        return $this->getIncomeByDateService($request, $from_date, $to_date);
    }
    public function getCarReport(Request $request, $car_number)
    {
        return $this->getCarReportService($request, $car_number);
    }
    public function getMonthlyReport(Request $request)
    {
        return $this->getMonthlyReportService($request);
    }
}
