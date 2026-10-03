<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'instructor_id' => Instructor::factory(),
            'code'  => strtoupper(fake()->unique()->lexify('???'))
                       . fake()->numberBetween(1, 4),
            'title' => fake()->sentence(3),
            'units' => 3,
        ];
    }
}
