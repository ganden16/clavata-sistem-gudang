<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Mutation extends Model implements Auditable
{
	/** @use HasFactory<\Database\Factories\MutationFactory> */
	use HasFactory, \OwenIt\Auditing\Auditable;

	protected $guarded = [];

	const TYPES_OPTIONS = ['in', 'out', 'adjustment_in', 'adjustment_out'];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
