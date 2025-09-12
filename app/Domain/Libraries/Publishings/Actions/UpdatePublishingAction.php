<?php

namespace App\Domain\Libraries\Publishings\Actions;

use App\Domain\Libraries\Publishings\DTO\StorePublishingDTO;
use App\Domain\Libraries\Publishings\DTO\UpdatePublishingDTO;
use App\Domain\Libraries\Publishings\Models\LibPublishing;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdatePublishingAction
{
    public function execute(UpdatePublishingDTO $dto)
    {
        DB::beginTransaction();
        try {
            $lib_publishing = $dto->getLibPublishing();
            $lib_publishing->name = $dto->getName();
            $lib_publishing->update();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

        return $lib_publishing;
    }
}
