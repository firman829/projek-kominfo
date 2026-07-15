<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'name' => $this->name,

            'institution' => $this->institution,

            'url' => $this->url,

            'domain' => $this->domain,

            'province' => $this->province,

            'city' => $this->city,

            'status' => $this->status,

            'description' => $this->description,

            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],

            'created_at' => optional($this->created_at)->format('Y-m-d H:i:s'),

            'updated_at' => optional($this->updated_at)->format('Y-m-d H:i:s'),

        ];
    }
}