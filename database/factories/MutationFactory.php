<?php

namespace Database\Factories;

use App\Models\Mutation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mutation>
 */
class MutationFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'user_id' => rand(1, 10),
			'product_id' => rand(1, 20),
			'type' => fake()->randomElement(Mutation::TYPES_OPTIONS),
			'amount' => rand(1, 10000),
			'description' => fake()->sentence(),
			'time' => fake()->time(),
			'date' => fake()->date(),
		];
	}
}
