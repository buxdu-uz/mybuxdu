<?php

namespace App\Domain\Libraries\Bbks\Actions;

use App\Domain\Libraries\Bbks\DTO\StoreBbkDTO;
use App\Domain\Libraries\Bbks\Models\LibBbk;
use Exception;
use Illuminate\Support\Facades\DB;

class StoreBbkAction
{
    /**
     * @param StoreBbkDTO $dto
     * @return LibBbk
     * @throws Exception
     */
    public function execute(StoreBbkDTO $dto): LibBbk
    {
        DB::beginTransaction();
        try {
            $bbk = new LibBbk();
            $bbk->sub_id = $dto->getSubId();
            $bbk->code = $dto->getCode();
            $bbk->name = $dto->getName();
            $bbk->info = $dto->getInfo();
            $bbk->is_active = $dto->isIsActive();
            $bbk->save();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $bbk;
    }
}
