<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' =>  fake()->numberBetween(1 ,10),
            'company_id' => fake()->numberBetween(1 ,10),
            'name' => fake()->domainWord(),
            'description' => fake()->paragraph(),
            'is_completed' => fake()->boolean(),
            'start_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'expired_at' => fake()->dateTimeBetween('now', '+1 week')
        ];
    }
}
