<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\History;
use App\Models\KwhMeter;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class HistoryController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {
        History::create([
            'kwh' => $request->kwh,
            'meter_id' => $request->meter_id,
            'time' => Carbon::yesterday()
        ]);

        return $this->success();
    }

    public function show(KwhMeter $kwhMeter)
    {
        $histories = History::where('meter_id', $kwhMeter->id)->latest('time')->limit(30)->get();
        return $this->success([
            'list' => $histories,
            'avg' => $histories->avg('kwh')
        ]);
    }
}
