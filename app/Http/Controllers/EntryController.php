<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntryRequest;
use App\Http\Services\EntryServices;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    use EntryServices;
    public function createEntry(EntryRequest $request)
    {
        return $this->createEntryService($request);
    }
    public function updateEntry(EntryRequest $request)
    {
        return $this->updateEntryService($request);
    }
    public function getEntries(Request $request)
    {
        return $this->getEntriesService($request);
    }
    public function getEntriesbyinout(Request $request, $car_in_or_out)
    {
        return $this->getEntriesbyinoutService($request, $car_in_or_out);
    }

    public function confirmExit(Request $request)
    {
        return $this->confirmExitService($request);
    }
    public function deleteEntry(Request $request)
    {
        return $this->deleteEntryService($request);
    }
    public function getInvoice(Request $request, $id)
    {
        return $this->getInvoiceService($request, $id);
    }
}
