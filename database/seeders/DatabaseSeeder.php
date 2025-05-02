<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Mutation;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		User::factory(10)->create();
		User::factory()->create([
			'username' => 'user',
		]);
		User::factory()->create([
			'username' => 'admin',
			'is_admin' => true,
		]);
		$users = User::all();

		$categories = Category::factory(5)->create();

		$products = Product::factory(50)->create([
			'category_id' => function () use ($categories) {
				return $categories->random()->id;
			},
		]);
		
		$mutations = Mutation::factory(200)->create([
			'product_id' => function () use ($products) {
				return $products->random()->id;
			},
			'user_id' => function () use ($users) {
				return $users->random()->id;
			},
		]);
	}
}
