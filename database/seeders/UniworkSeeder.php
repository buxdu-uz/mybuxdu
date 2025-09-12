<?php

namespace Database\Seeders;

use DateTime;
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
        function convertSqlServerHexDate(string $hex, bool $isDateTime = false, bool $dateOnly = false): string {
            $bin = hex2bin(substr($hex, 2));

            if (!$bin) {
                return 'NULL';
            }

            try {
                if ($isDateTime) {
                    $parts = unpack('V2', $bin);
                    $days = $parts[1];
                    $ticks = $parts[2]; // 1 tick = 1/300 sekund

                    $date = new DateTime('1900-01-01');
                    $date->modify("+{$days} days");

                    if (!$dateOnly) {
                        $seconds = intval($ticks / 300);
                        $milliseconds = round(($ticks % 300) * (1000 / 300));
                        if ($seconds > 0) {
                            $date->modify("+{$seconds} seconds");
                        }
                        $formatted = $date->format('Y-m-d H:i:s') . sprintf('.%03d', $milliseconds);
                    } else {
                        // faqat sana
                        $formatted = $date->format('Y-m-d');
                    }

                } else {
                    // DATE: 4 bayt
                    $days = unpack('V', $bin)[1];
                    $date = new DateTime('0001-01-01');
                    $date->modify("+{$days} days");

                    $formatted = $date->format('Y-m-d');
                }

                // Diapazonni tekshirish
                $checkFormatted = $isDateTime && !$dateOnly
                    ? $formatted
                    : $formatted . ' 00:00:00';

                if ($checkFormatted < '1000-01-01 00:00:00' || $checkFormatted > '9999-12-31 23:59:59.999') {
                    return 'NULL';
                }

                return "'$formatted'";
            } catch (\Throwable $e) {
                return 'NULL';
            }
        }

        $sqlPath = public_path('uniworks/libraries/books.sql');
        $content = File::get($sqlPath);

        // Hex qiymatlarni almashtirish
        $content = preg_replace_callback(
            "/0x([0-9A-F]+)(?=\s*[),])/i",
            function ($m) {
                $hex = "0x" . $m[1];

                // add_date ustuni uchun faqat sanani olish
                if (strlen($m[1]) === 16) {
                    // Agar SQLdagi field nomi add_date bo'lsa
                    if (stripos($m[0], 'add_date') !== false) {
                        return convertSqlServerHexDate($hex, true, true);
                    }
                    return convertSqlServerHexDate($hex, true);
                }

                return convertSqlServerHexDate($hex, false);
            },
            $content
        );

        DB::unprepared($content);

        return response()->json(['success' => 'Books imported successfully']);
    }

}
