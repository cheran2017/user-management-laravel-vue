<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'address_type',
        'door_street',
        'landmark',
        'city',
        'state',
        'country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
