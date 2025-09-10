<?php

namespace App\Domain\Libraries\Bbks\Actions;

use App\Domain\Libraries\Bbks\DTO\StoreBbkDTO;
use App\Domain\Libraries\Bbks\DTO\UpdateBbkDTO;
use App\Domain\Libraries\Bbks\Models\LibBbk;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateBbkAction
{
    /**
     * @param UpdateBbkDTO $dto
     * @return LibBbk
     * @throws Exception
     */
    public function execute(UpdateBbkDTO $dto): LibBbk
    {
        DB::beginTransaction();
        try {
            $bbk = $dto->getLibBbk();
            $bbk->sub_id = $dto->getSubId();
            $bbk->code = $dto->getCode();
            $bbk->name = $dto->getName();
            $bbk->info = $dto->getInfo();
            $bbk->is_active = $dto->isIsActive();
            $bbk->update();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $bbk;
    }
}
