<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$name = fake()->words(2, true);

		return [
			'category_id' => rand(1, 5),
			'name' => $name,
			'location' => fake()->sentence(),
			'description' => fake()->text(200),
			'unit' => fake()->randomElement(Product::UNIT_OPTIONS),
		];
	}
}
