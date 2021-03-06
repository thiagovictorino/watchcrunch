<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'username' => Str::replace('.', '-', $this->faker->userName),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
