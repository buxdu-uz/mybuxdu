<?php

namespace App\Domain\Libraries\Books\Actions;

use App\Domain\Libraries\Books\DTO\StoreLibBookDTO;
use App\Domain\Libraries\Books\Models\LibBook;
use App\Domain\Libraries\Books\Models\LibBookQr;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StoreLibBookAction
{
    public function execute(StoreLibBookDTO $dto)
    {
        DB::beginTransaction();
        try {
            $exists = LibBook::where('name', $dto->getName())
                ->where('lib_publishing_id', $dto->getLibPublishingId())
                ->where('lib_resource_type_id', $dto->getLibResourceTypeId())
                ->where('lib_bbk_id', $dto->getLibBbkId())
                ->first();

            // Kitob bo'lmasa, yangi yaratamiz
            $lib_book = $exists ?? LibBook::create([
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
                    'release_date' => $dto->getReleaseDate(),
                    'added_date' => now()
                ]);

            for ($i = 1; $i <= $dto->getNumber(); $i++) {
                $qrRecord = LibBookQr::create([
                    'lib_book_id' => $lib_book->id,
                    'qr_path'     => null,
                ]);

                $payload = (string) $qrRecord->id;
                $filename = "book_{$lib_book->id}_qr_{$qrRecord->id}.svg";

                $svg = QrCode::format('svg')->size(200)->generate($payload);

                Storage::put("files/qr_codes/{$filename}", $svg);

                $qrRecord->update([
                    'qr_path' => "files/qr_codes/{$filename}",
                ]);
            }


        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $lib_book;
    }
}
