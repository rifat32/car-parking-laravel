<?php

namespace App\Http\Services;

use App\Models\Entry;
use App\Models\Rate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

trait EntryServices
{
    public function createEntryService($request)
    {
        if (Entry::where(["car_number" => $request["car_number"], "is_car_out" => 0])->exists()) {
            return response()->json(["message" => "car already in"], 409);
        }
        $lastEntry = Entry::whereDate('created_at', Carbon::today("Asia/Dhaka"))->latest()->first();
        if ($lastEntry) {
            $request["token"] = $lastEntry->token + 1;
        } else {
            $request["token"] = 0;
        }
        $data = Entry::create($request->toArray());
        $data["invoice"] = view("welcomeinvoice", [
            "entry" => $data
        ])->render();

        return response()->json($data, 201);
    }
    public function updateEntryService($request)
    {
        $data = tap(Entry::where(["id" =>  $request["id"]]))->update(
            $request->only(
                "name",
                "phone_number",
                "address",
            )
        )->first();
        return response()->json($data, 201);
    }
    public function getEntriesService($request)
    {
        $data = Entry::orderByDesc("id")->paginate(10);
        return response()->json($data, 200);
    }
    public function getEntriesbyinoutService($request, $car_in_or_out)
    {
        $entryQuery = null;
        if ($car_in_or_out == "car_in") {
            $entryQuery = Entry::where([
                "is_car_out" => 0
            ]);
        } else if ($car_in_or_out == "car_out") {
            $entryQuery = Entry::where([
                "is_car_out" => 1
            ]);
        }

        $data = $entryQuery->orderByDesc("id")->paginate(10);
        return response()->json($data, 200);
    }

    public function deleteEntryService($request)
    {
        Entry::where(["id" => $request->id])->delete();
        return response()->json(["ok" => true], 200);
    }
    public function confirmExitService($request)
    {
        $entryQuery = Entry::where(["id" => $request->id]);
        $entry =  $entryQuery->first();
        if ($entry->is_car_out == 1) {
            return response()->json(["message" => "duplicate entry"], 409);
        }
        $currentTime = Carbon::now("Asia/Dhaka");

        $entryCarbonTime =   Carbon::create($entry->created_at);
        $exitCarbonTime = Carbon::create($currentTime);


        $entryTimeInMilliseconds = (int) ($entryCarbonTime->timestamp . str_pad($entryCarbonTime->milli, 3, '0', STR_PAD_LEFT));
        $exitTimeInMilliseconds = (int) ($exitCarbonTime->timestamp . str_pad($exitCarbonTime->milli, 3, '0', STR_PAD_LEFT));


        $timeSpentMili = $exitTimeInMilliseconds -  $entryTimeInMilliseconds;

        $timeSpentHour = $timeSpentMili / 1000 /  60 / 60;

        $hourlyRate = Rate::first()->rate;
        if (!$hourlyRate) {
            return response()->json(["message" => "You did not provide hourly rate"], 404);
        }
        $bill = $hourlyRate * $timeSpentHour;

        $data["entry"] =  tap(Entry::where(["id" => $request->id]))->update([
            "exit_time" => $currentTime,
            "bill" => $bill,
            "is_car_out" => 1,
            "time_spent_mili" => $timeSpentMili

        ])->first();

        $data["invoice"] = view("exitinvoice", [
            "entry" => $data["entry"]
        ])->render();
        return response()->json($data, 200);
    }
    public function getInvoiceService($request, $id)
    {
        $entry = Entry::where(["id" => $id])->first();
        if ($entry->is_car_out == 0 || $entry->is_car_out == false) {
            $data["invoice"] = view("welcomeinvoice", [
                "entry" => $entry
            ])->render();
        } else {
            $data["invoice"] = view("exitinvoice", [
                "entry" => $entry
            ])->render();
        }

        return response()->json($data, 200);
    }
}
