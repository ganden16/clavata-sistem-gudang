<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
			'name' => $this->name,
			'username' => $this->username,
			'email' => $this->email,
			'is_admin' => (bool) $this->is_admin,
			'gender' => $this->gender ? 'Laki-laki' : 'Perempuan',
			'gender_boolean' => (bool) $this->gender,
			'address' => $this->address ?? null,
			'religion' => $this->religion ?? null,
			'whatsapp' => $this->whatsapp ?? null,
			'telephone' => $this->telephone ?? null,
			'created_at' => $this->created_at->toISOString(),
			'updated_at' => $this->updated_at->toISOString(),
		];
	}
}
