<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\History;
use App\Models\KwhMeter;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::create([
            'username' => 'audi',
            'password' => bcrypt('audi')
        ]);

        $user2 = User::create([
            'username' => 'adyan',
            'password' => bcrypt('adyan')
        ]);

        KwhMeter::create([
            'id' => "144298637843",
            'password' => Hash::make("anjai"),
            'accessCode' => "123ghsg64h",
            'name' => 'kamvret',
            'user_id' => $user1->id
        ]);

        KwhMeter::create([
            'id' => "142564827383",
            'password' => Hash::make("anjai"),
            'accessCode' => "sdfjksd7f8",
            'name' => 'sukur',
            'user_id' => $user1->id
        ]);

        KwhMeter::create([
            'id' => "141637829045",
            'password' => Hash::make("anjai"),
            'accessCode' => "nmc98xbhvn",
            'name' => 'sial',
            'user_id' => $user2->id
        ]);

        Transaction::create([
            'kwhAdd' => mt_rand(1, 10),
            'price' => mt_rand(1, 99999),
            'meter_id' => "144298637843"
        ]);

        Transaction::create([
            'kwhAdd' => mt_rand(1, 10),
            'price' => mt_rand(1, 99999),
            'meter_id' => "144298637843"
        ]);

        Transaction::create([
            'kwhAdd' => mt_rand(1, 10),
            'price' => mt_rand(1, 99999),
            'meter_id' => "142564827383"
        ]);

        Transaction::create([
            'kwhAdd' => mt_rand(1, 10),
            'price' => mt_rand(1, 99999),
            'meter_id' => "141637829045"
        ]);

        Transaction::create([
            'kwhAdd' => mt_rand(1, 10),
            'price' => mt_rand(1, 99999),
            'meter_id' => "141637829045"
        ]);

        History::create([
            'kwh' => mt_rand(1, 10),
            'meter_id' => "141637829045"
        ]);

        History::create([
            'kwh' => mt_rand(1, 10),
            'meter_id' => "141637829045"
        ]);

        History::create([
            'kwh' => mt_rand(1, 10),
            'meter_id' => "141637829045"
        ]);

        History::create([
            'kwh' => mt_rand(1, 10),
            'meter_id' => "142564827383"
        ]);

        History::create([
            'kwh' => mt_rand(1, 10),
            'meter_id' => "142564827383"
        ]);

        History::create([
            'kwh' => mt_rand(1, 10),
            'meter_id' => "144298637843"
        ]);
    }
}
