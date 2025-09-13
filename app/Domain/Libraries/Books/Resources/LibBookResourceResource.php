<?php

namespace App\Domain\Libraries\Books\Resources;

use App\Domain\Libraries\Bbks\Resources\BbkResource;
use App\Domain\Libraries\Publishings\Resources\PublishingResource;
use App\Domain\Libraries\Resources\Resources\ResourceTypeResource;
use App\Enums\LibBookResourceEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibBookResourceResource extends JsonResource
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
            'in_whom_id' => $this->in_whom_id,
            'status' => $this->status->label(),
            'add_date' => $this->add_date,
            'oh_date' => $this->oh_date,
            'arrival_date' => $this->arrival_date,
            'qrs' => new BookQrResource($this->qr)
        ];
    }
}
