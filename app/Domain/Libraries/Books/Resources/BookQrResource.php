<?php

namespace App\Domain\Libraries\Books\Resources;

use App\Domain\Libraries\Bbks\Resources\BbkResource;
use App\Domain\Libraries\Publishings\Resources\PublishingResource;
use App\Domain\Libraries\Resources\Resources\ResourceTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookQrResource extends JsonResource
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
            'qr_path' => $this->qr_path,
            'qr_url' => $this->qr_path
                ? asset('storage/public/' . $this->qr_path)
                : null,
        ];
    }
}
