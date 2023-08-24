<?php

namespace App\Http\Controllers;

use App\Models\KwhMeter;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use PhpMqtt\Client\Facades\MQTT;

class TransactionController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {
        $transaction = Transaction::create([
            'kwhAdd' => $request->kwhAdd,
            'price' => $request->price,
            'meter_id' => $request->meter_id,
        ]);

        $topic = "kwh/token/" . $transaction->meter_id;
        $data = json_encode([
            'id' => $transaction->id,
            'kwhAdd' => $transaction->kwhAdd
        ]);

        $mqtt = MQTT::connection();
        $mqtt->publish($topic, $data, 2);
        $mqtt->loop(true, true);

        return $this->success();
    }

    public function show(KwhMeter $kwhMeter)
    {
        $transactions = Transaction::where('meter_id', $kwhMeter->id)->latest('time')->paginate(5);
        return $this->success($transactions);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $kwhCurr = $request->kwhPrev + $transaction->kwhAdd;

        $transaction->update([
            'kwhPrev' => $request->kwhPrev,
            'kwhCurr' => $kwhCurr,
            'status' => true,
        ]);

        return $this->success();
    }
}
