<?php

namespace Database\Factories;

use App\Models\Aluno;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlunoFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Aluno::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->first()->id,
            'name' => $this->faker->name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
