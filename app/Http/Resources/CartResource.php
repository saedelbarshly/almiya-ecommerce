<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            return [
                'id' => (int) $this->product_id,
                'name' => (string) $this->product?->name,
                'image' => (string) $this->product?->image,
                'quantity' => (int) $this->quantity,
            ];
    }
}
