<?php

use App\Models\Mutation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('mutations', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
			$table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
			$table->enum('type', Mutation::TYPES_OPTIONS);
			$table->date('date');
			$table->time('time');
			$table->double('amount');
			$table->text('description')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('mutations');
	}
};
