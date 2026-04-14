<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date,

            'assigned_to' => $this->whenLoaded('assignedUser') ?? null,
            'created_by' => $this->whenLoaded('creator') ?? null,

            'activities' => TaskActivityResource::collection(
                $this->whenLoaded('activities')
            ),
        ];
    }
}
