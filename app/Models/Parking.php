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
        "parking_fee",
        "updated_at"
    ];

    protected $casts = [
        "exit_time" => 'datetime:Y-m-d H:m:s',
        "created_at" => 'datetime:Y-m-d H:m:s',
        "updated_at" => 'datetime:Y-m-d H:m:s',
    ];
}
