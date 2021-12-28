<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AulaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $aulas = ['Ioga', 'Música', 'Coral', 'CrossFit', 'Natação', 'Programação Web'];

        $start =  $this->faker->time;
        // $this->faker->dateTimeBetween('-10 months')->format('Y-m-d');
        return [
            'day' => $this->faker->dateTimeBetween('-10 months')->format('Y-m-d'),
            'hour_start' => $start,
            'hour_end' => Carbon::make($start)->addHours(rand(1, 4)),
            'name' => $this->faker->randomElement($aulas),
            'teacher' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'seat_limit' => rand(10, 30),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
