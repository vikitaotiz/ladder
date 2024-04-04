<?php

namespace App\Http\Resources\Users;

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
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "active" => $this->active,
            "roles" => $this->roles->map->only('id', 'name'),
            "created_at" => $this->created_at->format('h:i:s A, jS D M Y'),
        ];
    }
}
