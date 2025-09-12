<?php

namespace App\Domain\Libraries\Publishings\Actions;

use App\Domain\Libraries\Publishings\DTO\StorePublishingDTO;
use App\Domain\Libraries\Publishings\Models\LibPublishing;
use Exception;
use Illuminate\Support\Facades\DB;

class StorePublishingAction
{
    public function execute(StorePublishingDTO $dto)
    {
        DB::beginTransaction();
        try {
            $lib_publishing = new LibPublishing();
            $lib_publishing->name = $dto->getName();
            $lib_publishing->save();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

        return $lib_publishing;
    }
}
