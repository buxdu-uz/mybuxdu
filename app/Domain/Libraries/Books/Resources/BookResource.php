<?php

namespace App\Domain\Libraries\Books\Resources;

use App\Domain\Libraries\Publishings\Resources\PublishingResource;
use App\Domain\Libraries\Resources\Resources\ResourceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'humen_id' => $this->humen_id,
            'classifier' => $this->classifier,
            'name' => $this->name,
            'author' => $this->author,
            'annotation' => $this->annotation,
            'number' => $this->number,
            'page' => $this->page,
            'price' => $this->price,
            'release_date' => $this->release_date,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'resource' => new ResourceResource($this->resource),
            'publishing' => new PublishingResource($this->publishing),
        ];
    }
}
