<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
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
        return Arr::except(parent::toArray($request), [
            'created_at', 'updated_at', 'banned_at', 'deleted_at', 'email', 'email_verified_at'
        ]);
    }
}
