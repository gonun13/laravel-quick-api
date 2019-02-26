<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'city' => $this->city,
            'country' => $this->country,
            'industry' => $this->industry,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'reviews' => $this->reviews,
          ];
    }
}
