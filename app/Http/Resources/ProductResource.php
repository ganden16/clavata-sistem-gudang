<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'category_id' => $this->category_id ?? null,
			'category' => $this->category,
			'code' => $this->code,
			'name' => $this->name,
			'description' => $this->description ?? null,
			'unit' => $this->unit,
			'created_at' => $this->created_at->toISOString(),
			'updated_at' => $this->updated_at->toISOString(),
		];
	}
}
