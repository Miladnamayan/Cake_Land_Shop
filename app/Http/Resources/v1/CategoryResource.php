<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'parent_id'=>$this->parent_id,
            'name'=>strtoupper($this->name),
            'description'=>$this->description,
            'Subcategory' => $this->whenLoaded('Subcategory'),
            'parentcategory' => $this->whenLoaded('parentcategory'),
            'products' => ProductResource::collection($this->whenLoaded('products',
                function(){
                    return $this->products->load('images');
                })
            ),
        ];
    }
}


