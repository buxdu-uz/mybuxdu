<?php

namespace Database\Seeders;

use App\Domain\Libraries\Books\Models\LibBook;
use DateTime;
use DateTimeImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UniworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->bbks();
        $this->resource_types();
        $this->publishings();
        $this->books();
        $this->lib_book_resources();
    }

    private function parseHexDate($val)
    {
        $val = trim($val);

        if ($val === '' || strtoupper($val) === 'NULL') {
            return null;
        }

        // Agar allaqachon oddiy datetime string bo'lsa (masalan '2021-10-01 12:00:00')
        if (!str_starts_with($val, '0x')) {
            return trim($val, " '");
        }

        return $this->convertSqlServerHexDate($val);
    }


    private function convertSqlServerHexDate(string $hex): ?string
    {
        $hex = trim($hex);

        if (empty($hex) || strtoupper($hex) === 'NULL') {
            return null;
        }

        if (!str_starts_with($hex, '0x')) {
            return null;
        }

        $bin = @hex2bin(substr($hex, 2));
        if ($bin === false) {
            return null;
        }

        $len = strlen($bin);

        // ==== SQL Server DATETIME (8 byte) ====
        if ($len === 8) {
            // reverse each 4-byte block (needed for how SQL Server hex was dumped)
            $part1 = strrev(substr($bin, 0, 4));
            $part2 = strrev(substr($bin, 4, 4));

            $u1 = unpack('V', $part1); // unsigned long (little-endian)
            $u2 = unpack('V', $part2);

            $days = $u1[1];
            $time = $u2[1];

            // empty datetime
            if ($days === 0 && $time === 0) {
                return null;
            }

            $date = new \DateTimeImmutable('1900-01-01 00:00:00');

            // qo'shamiz kunlarni (butun)
            $date = $date->modify("+{$days} days");

            // Sekundni butun qismiga olamiz (time birligi = 1/300 s)
            $seconds = intdiv($time, 300);
            $date = $date->modify("+{$seconds} seconds");

            // microsecond (ixtiyoriy, agar xohlasangiz qo'shish mumkin)
            $remainder = $time % 300;
            if ($remainder !== 0) {
                $micro = (int) round($remainder * (1000000 / 300)); // 300 bo'lak -> microsecond
                return $date->format('Y-m-d H:i:s') . '.' . str_pad($micro, 6, '0', STR_PAD_LEFT);
            }

            return $date->format('Y-m-d H:i:s');
        }

        // ==== SQL Server SMALLDATETIME (4 byte) ====
        if ($len === 4) {
            // 2 byte - days; 2 byte - minutes
            // reverse each 2-byte pair (tuzatilgan tartib)
            $p1 = strrev(substr($bin, 0, 2));
            $p2 = strrev(substr($bin, 2, 2));

            $days = unpack('v', $p1)[1];    // unsigned short (little-endian)
            $minutes = unpack('v', $p2)[1];

            $date = new \DateTimeImmutable('1900-01-01 00:00:00');
            $date = $date->modify("+{$days} days");
            $date = $date->modify("+{$minutes} minutes");

            return $date->format('Y-m-d H:i:s');
        }

        // Boshqa uzunliklar (datetime2 va boshqalar) bo'lsa, fallback sifatida originalni qaytaring
        return trim($hex, " '");
    }

    public function bbks()
    {
        $sqlPath = public_path('uniworks/libraries/bbk.sql');
        $sql = File::get($sqlPath);

        $lines = explode("\n", $sql);

        foreach ($lines as &$line) {
            if (stripos($line, 'INSERT INTO lib_bbks') !== false) {
                // Ustun nomlarini olish
                if (preg_match("/INSERT INTO\s+lib_bbks\s*\((.*?)\)/i", $line, $cols)) {
                    $columns = array_map('trim', explode(',', $cols[1]));

                    // VALUES qismini topib qayta ishlash
                    $line = preg_replace_callback(
                        "/VALUES\s*\((.*?)\)/i",
                        function ($m) use ($columns) {
                            $values = array_map('trim', explode(',', $m[1]));

                            foreach ($columns as $i => $col) {
                                if (strtolower($col) === 'sub_id' && isset($values[$i]) && $values[$i] === '0') {
                                    $values[$i] = 'NULL'; // faqat sub_id ustuni uchun
                                }
                            }

                            return 'VALUES (' . implode(', ', $values) . ')';
                        },
                        $line
                    );
                }
            }
        }

        $sql = implode("\n", $lines);

        DB::unprepared($sql);

        return response()->json(['success' => 'BBKs imported successfully']);
    }

    public function resource_types()
    {
        $sqlPath = public_path('uniworks/libraries/resource_type.sql');
        $sql = File::get($sqlPath);

        DB::unprepared($sql);
    }

    public function publishings()
    {
        $sqlPath = public_path('uniworks/libraries/publishing.sql');
        $sql = File::get($sqlPath);

        DB::unprepared($sql);
    }

    public function books()
    {
        $sqlPath = public_path('uniworks/libraries/books.sql');
        $content = File::get($sqlPath);

        // Faqat VALUES qismlarini olish
        preg_match_all(
            "/INSERT INTO lib_books\s*\([^)]+\)\s*VALUES\s*\(([^)]+)\);/i",
            $content,
            $matches
        );

        $rows = [];
        foreach ($matches[1] as $valuesString) {
            // CSV parser yordamida VALUES ichini arrayga aylantiramiz
            $values = str_getcsv($valuesString, ',', "'", "\\");
            $rows[] = [
                'id'                  => (int) trim($values[0]) ?? null,
                'name'                => trim($values[1], " '") ?? null,
                'author'              => trim($values[2], " '") ?? null,
                'lib_resource_type_id'=> (int) trim($values[3]) ?? null,
                'lib_publishing_id'   => (int) trim($values[4]) ?? null,
                // release_date hex bo‘lishi mumkin → convert qiling
                'release_date'        => $this->convertSqlServerHexDate(trim($values[5])) ?? null,
                'page'                => (int) trim($values[6]) ?? null,
                'lib_bbk_id'          => (int) trim($values[7]) ?? null,
                'price'               => (float) trim($values[8]) ?? null,
                'image'               => strtoupper(trim($values[9])) === 'NULL' ? null : trim($values[9], " '"),
                'number'              => (int) trim($values[10]) ?? null,
                'annotation'          => strtoupper(trim($values[11])) === 'NULL' ? null : trim($values[11], " '"),
                'is_active'           => (int) trim($values[12]) ?? 1,
                'humen_id'            => strtoupper(trim($values[13])) === 'NULL' ? null : (int) $values[13],
                // add_date hex bo‘lishi mumkin
                'add_date'            => $this->convertSqlServerHexDate(trim($values[14])) ?? null,
            ];
        }

        // 1000 tadan bo‘lib insert qilish
        foreach (array_chunk($rows, 1000) as $chunk) {
            DB::table('lib_books')->insert($chunk);
        }

        return response()->json(['success' => 'Books imported successfully']);
    }

    public function lib_book_resources()
    {
        $sqlPath = public_path('uniworks/libraries/resources.sql');
        $content = File::get($sqlPath);

// Faqat VALUES qismlarini olish
        preg_match_all(
            "/INSERT INTO lib_book_resources\s*\([^)]+\)\s*VALUES\s*\(([^)]+)\);/i",
            $content,
            $matches
        );

        $rows = [];

        foreach ($matches[1] as $valuesString) {
            $values = str_getcsv($valuesString, ',', "'", "\\");
            if (LibBook::find((int) trim($values[1])) !== null) {
                $rows[] = [
                    'id'          => (int) trim($values[0]) ?? null,
                    'lib_book_id' => (int) trim($values[1]) ?? null,
                    'status'      => (int) trim($values[3]) ?? null,
                    'in_whom_id'  => strtoupper(trim($values[4])) === 'NULL' ? null : (int) $values[4],
                    'add_date'    => $this->parseHexDate($values[5]),
                    'oh_date'     => $this->parseHexDate($values[6]),
//                    'add_date'    => $values[5] ?? null,
//                    'oh_date'     => $values[6] ?? null,
                    'humen_id'    => strtoupper(trim($values[7])) === 'NULL' ? null : (int) $values[7],
                    'arrival_date'=> strtoupper(trim($values[8])) === 'NULL' ? null : $values[8],
                ];
            }
        }

// 1000 tadan bo‘lib insert qilish
        foreach (array_chunk($rows, 1000) as $chunk) {
            DB::table('lib_book_resources')->insert($chunk);
        }
    }

}
