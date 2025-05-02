<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MutationResource extends JsonResource
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
			'user_id' => $this->user_id ?? null,
			'product_id' => $this->product_id ?? null,
			'type' => $this->type,
			'type_label' => match ($this->type) {
				'in' => 'Masuk',
				'out' => 'Keluar',
				'adjustment_in' => 'Penyesuaian Masuk',
				'adjustment_out' => 'Penyesuaian Keluar',
			},
			'amount' => $this->amount,
			'description' => $this->description ?? null,
			'date' => $this->date,
			'time' => $this->time,
			'created_at' => $this->created_at->toISOString(),
			'updated_at' => $this->updated_at->toISOString(),
		];
	}
}
