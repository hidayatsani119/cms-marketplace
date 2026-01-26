<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductQrCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'product_id' => $this->product_id,
            'qr_token' => $this->qr_token,
            'qr_image_path' => $this->qr_image_path,
            'qr_image_url' => $this->qr_image_url
        ];
    }
}
