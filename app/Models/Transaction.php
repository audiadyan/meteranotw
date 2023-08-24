<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $attributes = [
        'kwhPrev' => 0,
        'kwhCurr' => 0,
        'status' => false,
    ];

    public $timestamps = false;

    public function kwhMeter()
    {
        return $this->belongsTo(KwhMeter::class, 'meter_id');
    }
}
