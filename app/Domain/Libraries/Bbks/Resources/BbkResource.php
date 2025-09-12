<?php

namespace App\Domain\Libraries\Bbks\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BbkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'info' => $this->info,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'resources_count' => $this->resources_count,
            'children' => BbkChildResource::collection($this->children)
        ];
    }
}
