<?php

namespace App\Console\Commands;

use App\Domain\Libraries\Books\Models\LibBook;
use App\Domain\Libraries\Books\Models\LibBookQr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeGenerationOldBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'old-book:generate-qr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uniworkdagi kitoblarni qaytib generatsiya qilish qrcodlarini';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $books = LibBook::query()
            ->get();

        foreach ($books as $book) {
            echo "Processing book ID: {$book->id}\n";
            for ($i = 1; $i <= $book->number; $i++) {
                echo "Processing book qrcode: {$i}\n";
                $qrRecord = LibBookQr::create([
                    'lib_book_id' => $book->id,
                    'qr_path'     => null,
                ]);

                $payload = (string) $qrRecord->id;
                $filename = "book_{$book->id}_qr_{$qrRecord->id}.svg";

                $svg = QrCode::format('svg')->size(200)->generate($payload);

                Storage::put("files/qr_codes/{$filename}", $svg);

                $qrRecord->update([
                    'qr_path' => "files/qr_codes/{$filename}",
                ]);
            }
        }
    }
}
