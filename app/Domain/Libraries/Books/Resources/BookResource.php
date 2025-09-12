<?php

namespace App\Domain\Libraries\Books\Resources;

use App\Domain\Libraries\Bbks\Resources\BbkResource;
use App\Domain\Libraries\Publishings\Resources\PublishingResource;
use App\Domain\Libraries\Resources\Resources\ResourceTypeResource;
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
            'name' => $this->name,
            'author' => $this->author,
            'annotation' => $this->annotation,
            'number' => $this->number,
            'page' => $this->page,
            'price' => $this->price,
            'release_date' => $this->release_date,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'qrs' => BookQrResource::collection($this->qrs),
            'bbk' => new BbkResource($this->bbk),
            'resource' => new ResourceTypeResource($this->resourceType),
            'publishing' => new PublishingResource($this->publishing),
        ];
    }
}
