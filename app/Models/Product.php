<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
	/** @use HasFactory<\Database\Factories\ProductFactory> */
	use HasFactory, \OwenIt\Auditing\Auditable, HasUuids, Searchable, SoftDeletes;

	protected $guarded = [];

	const UNIT_OPTIONS = [
		'pcs',
		'buah',
		'kg',
		'gram',
		'liter',
		'meter',
		'cm',
		'inci',
		'kotak',
		'rim',
		'pack',
		'lusin',
		'karton',
		'roll',
		'dus'
	];


	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}

	public function toSearchableArray()
	{
		return [
			'name' => $this->name,
			'code' => $this->code,
			'description' => $this->description,
		];
	}

	public function uniqueIds()
	{
		return ['code'];
	}
}
