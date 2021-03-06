<?php

namespace Database\Factories;

use App\Models\Parking;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $exit_time = $this->faker->dateTimeBetween('now', '+1 day');
        $parking_fee = $this->faker->numberBetween(3000, 40000);

        return [
            "license_plate" => Str::upper(Str::random(6)),
            "unique_code" => Str::random(6),
            "exit_time" => $exit_time,
            "parking_fee" => round($parking_fee, -2, PHP_ROUND_HALF_UP),
            "updated_at" => $exit_time
        ];
    }
}
