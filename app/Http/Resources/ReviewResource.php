<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'company_id' => $this->company_id,
            'user' => $this->user,
            'title' => $this->title,
            'pro' => $this->pro,
            'contra' => $this->contra,
            'suggestions' => $this->suggestions,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'rating' => $this->rating,
          ];
    }
}
