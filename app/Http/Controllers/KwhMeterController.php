<?php

namespace App\Http\Controllers;

use App\Models\KwhMeter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class KwhMeterController extends Controller
{
    use HttpResponses;

    public function home()
    {
        return view('pages.home');
    }

    public function index()
    {
        return view('pages.admin');
    }

    public function print()
    {
        $data = KwhMeter::find(request("kwhMeter"));
        // dd($data);
        return view('pages.print.access-code', [
            'id' => $data->id,
            'code' => $data->accessCode,
            'name' => $data->name
        ]);
    }

    public function monitoring()
    {
        $id = request('id');
        $code = request('code');

        $result = KwhMeter::find($id);
        if($result == null)
        {
            return redirect(route('home'));
        }

        if($result->accessCode != $code)
        {
            return redirect(route('home'));
        }
        return view('pages.monitoring', [
            'data' => $result
        ]);
    }

    public function store(Request $request)
    {
        KwhMeter::create([
            'id' => $request->id,
            'password' => Hash::make($request->password),
            'accessCode' => substr(md5(time()), 0, 10)
        ]);

        return $this->success();
    }

    public function update(Request $request, KwhMeter $kwhMeter)
    {
        $kwhMeter->update([
            'kwh' => $request->kwh,
            'kwhUsed' => $request->kwhUsed,
            'updated_at' => now()
        ]);

        return $this->success();
    }

    public function generate(KwhMeter $kwhMeter)
    {
        $kwhMeter->update([
            'accessCode' => Str::random(10)
        ]);

        return $this->success([
            'accessCode' => $kwhMeter->accessCode
        ]);
    }

    public function show(KwhMeter $kwhMeter)
    {
        return $this->success([
            'name' => $kwhMeter->name,
            'kwh' => $kwhMeter->kwh,
            'kwhUsed' => $kwhMeter->kwhUsed,
            'accessCode' => $kwhMeter->accessCode,
            'updated_at' => $kwhMeter->updated_at
        ]);
    }

    public function list()
    {
        $list = KwhMeter::where('user_id', request('id'))->orderBy('name')->get();
        return $this->success($list);
    }

    public function addList(Request $request)
    {
        $kwhMeter = KwhMeter::find($request->id);

        if($kwhMeter == null) {
            return $this->error("ID/Password Salah!", 202);
        }

        if(!Hash::check($request->password, $kwhMeter->password)) {
            return $this->error("ID/Password Salah!", 202);
        }

        $kwhMeter->update([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return $this->success();
    }

    public function destroy(KwhMeter $kwhMeter)
    {
        $kwhMeter->update([
            'user_id' => null,
            'name' => null
        ]);

        return $this->success();
    }
}
