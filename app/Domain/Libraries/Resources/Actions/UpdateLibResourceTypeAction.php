<?php

namespace App\Domain\Libraries\Resources\Actions;

use App\Domain\Libraries\Publishings\DTO\StorePublishingDTO;
use App\Domain\Libraries\Publishings\Models\LibPublishing;
use App\Domain\Libraries\Resources\DTO\StoreLibResourceTypeDTO;
use App\Domain\Libraries\Resources\DTO\UpdateLibResourceTypeDTO;
use App\Domain\Libraries\Resources\Models\LibResourceType;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateLibResourceTypeAction
{
    public function execute(UpdateLibResourceTypeDTO $dto)
    {
        DB::beginTransaction();
        try {
            $lib_resource_type = $dto->getLibResourceType();
            $lib_resource_type->name = $dto->getName();
            $lib_resource_type->update();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

        return $lib_resource_type;
    }
}
