<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HandymanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => UserResource::make($this->whenLoaded('user')),
            // 'subscription_type' => SubscriptionTypeResource::make($this->whenLoaded('subscription_type')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'services' => ServiceResource::collection($this->whenLoaded('services')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'quotes' => QuoteResource::collection($this->whenLoaded('quotes')),

            $this->merge(Arr::except(parent::toArray($request), [
                'created_at', 'updated_at', 'banned_at', 'deleted_at', 'email', 'email_verified_at'
            ]))
        ];
    }
}
