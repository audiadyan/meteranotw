<?php

namespace App\Models;

use App\Models\User;
use App\Models\History;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KwhMeter extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'kwh' => 0,
        'kwhUsed' => 0,
        'name' => null,
        'user_id' => null,
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
