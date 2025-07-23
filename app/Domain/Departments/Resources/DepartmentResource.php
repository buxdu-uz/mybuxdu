<?php

namespace App\Domain\Departments\Resources;

use App\Domain\Roles\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'active' => $this->active,
            'code' => $this->code,
            'name' => $this->name,
            'structure_type' => $this->structureType,
            'locality_type' => $this->localityType
        ];
    }
}
