<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccasionResource extends JsonResource
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
            'name'=>strtoupper($this->name),
            'display_name'=>strtoupper($this->display_name),
            'products' => ProductResource::collection($this->whenLoaded('products',
                function(){
                    return $this->products->load('images');
                })
            ) ,
        ];
    }
}
