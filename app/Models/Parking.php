<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    // created_at field used for car entry time

    protected $fillable = [
        "license_plate",
        "unique_code",
        "exit_time",
        "parking_fee"
    ];
}
