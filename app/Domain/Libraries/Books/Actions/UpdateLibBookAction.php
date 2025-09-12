<?php

namespace App\Domain\Libraries\Books\Actions;

use App\Domain\Libraries\Books\DTO\StoreLibBookDTO;
use App\Domain\Libraries\Books\DTO\UpdateLibBookDTO;
use App\Domain\Libraries\Books\Models\LibBook;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateLibBookAction
{
    public function execute(UpdateLibBookDTO $dto)
    {
        DB::beginTransaction();
        try {
            $dto->getLibBook()->update([
                'lib_resource_type_id' => $dto->getLibResourceTypeId(),
                'lib_publishing_id' => $dto->getLibPublishingId(),
                'lib_bbk_id' => $dto->getLibBbkId(),
                'name' => $dto->getName(),
                'author' => $dto->getAuthor(),
                'annotation' => $dto->getAnnotation(),
                'number' => $dto->getNumber(),
                'is_active' => $dto->isIsActive(),
                'page' => $dto->getPage(),
                'image' => $dto->getImage(),
                'price' => $dto->getPrice(),
                'release_date' => $dto->getReleaseDate()
            ]);
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $dto->getLibBook();
    }
}
