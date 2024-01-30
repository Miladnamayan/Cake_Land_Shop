<?php

namespace App\Http\Resources\v1;

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
        // return parent::toArray($request);
        return[
            'id'=>$this->id,
            'occasion_id'=>$this->occasion_id,
            'category_id'=>$this->category_id,
            'name'=>strtoupper($this->name),
            'primary_image'=>url( env('PRODUCT_IMAGE_UPLOAD_PATH') . $this->primary_image),
            'description'=>$this->description,
            'price'=>$this->price,
            'quantity'=>$this->quantity,
            'delivery_amount'=>$this->delivery_amount,
            'images' => ProductImageResource::collection($this->whenLoaded('images')) ,

        ];
    }
}
