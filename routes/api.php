<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    $user = $request->user();
    $data["user"] = $user;
    return response()->json(
        $data,
        200
    );
});
Route::post('/login', [AuthController::class, "login"]);
Route::post('/register', [AuthController::class, "register"]);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::post("/entries", [EntryController::class, "createEntry"]);
    Route::put("/entries", [EntryController::class, "updateEntry"]);
    Route::delete("/entries/{id}", [EntryController::class, "deleteEntry"]);
    Route::get("/entries", [EntryController::class, "getEntries"]);
    Route::get("/entries/{car_in_or_out}", [EntryController::class, "getEntriesbyinout"]);
    Route::put("/entries/exit", [EntryController::class, "confirmExit"]);
    Route::get("/rate", [RateController::class, "getRate"]);
    Route::post("/rate", [RateController::class, "updateRate"]);
    // reports
    Route::get("/reports/income/total", [ReportController::class, "getTotalIncome"]);
    Route::get("/report/income/{from_date}/{to_date}", [ReportController::class, "getIncomeByDate"]);
    Route::get("/report/car/{car_number}", [ReportController::class, "getCarReport"]);
    Route::get("/report/monthly", [ReportController::class, "getMonthlyReport"]);

    // /report/car/${formData.car_number}
    Route::get("/invoice/{id}", [EntryController::class, "getInvoice"]);
});
