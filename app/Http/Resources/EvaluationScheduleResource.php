<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'website' => [

                'id' => $this->website?->id,

                'name' => $this->website?->name,

                'url' => $this->website?->url,

            ],

            'start_time' => $this->start_time,

            'end_time' => $this->end_time,

            'interval_minutes' => $this->interval_minutes,

            'working_days' => [

                'monday' => $this->monday,
                'tuesday' => $this->tuesday,
                'wednesday' => $this->wednesday,
                'thursday' => $this->thursday,
                'friday' => $this->friday,
                'saturday' => $this->saturday,
                'sunday' => $this->sunday,

            ],

            'is_active' => $this->is_active,

            'status' => $this->is_active
                ? 'Aktif'
                : 'Tidak Aktif',

            'last_run_at' => $this->last_run_at,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

        ];
    }
}