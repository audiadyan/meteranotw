<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function kwhmeter()
    {
        return $this->hasMany(KwhMeter::class)->orderBy('name');
    }
}
