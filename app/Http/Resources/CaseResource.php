<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'link'        => $this->link,
            'price'       => $this->formatted_price,
            'description' => $this->description,
            'gallery'     => $this->gallery,
            'properties'  => $this->properties,
        ];
    }
}
