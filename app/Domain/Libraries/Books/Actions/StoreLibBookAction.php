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
            $lib_book = LibBook::create([
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

                // Avval bazaga yozamiz
                $qrRecord = LibBookQr::create([
                    'lib_book_id' => $lib_book->id,
                    'qr_path'     => null, // hozircha bo‘sh
                ]);

                // Payload endi lib_book_qrs jadvalidagi id
                $payload = (string) $qrRecord->id;

                // Fayl nomi
                $filename = "book_{$lib_book->id}_qr_{$qrRecord->id}.svg";

                // QR code PNG binary yaratamiz
                $png = QrCode::format('svg')->size(200)->generate($payload);

                // Saqlash (storeAs ishlashi uchun fayl sifatida yozish kerak)
                Storage::put("public/files/qr_codes/{$filename}", $png);

                // URL ni yangilash
                $qrRecord->update([
                    'qr_path' => "files/qr_codes/{$filename}", // faqat storage ichidagi nisbiy yo‘l
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
