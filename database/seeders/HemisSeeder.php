<?php

namespace Database\Seeders;

use App\Domain\Classifiers\Models\Classifier;
use App\Domain\Classifiers\Models\ClassifierOption;
use App\Domain\Departments\Models\Department;
use App\Domain\Specialities\Models\Speciality;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HemisSeeder extends Seeder
{
    /**
     * @var mixed|Client
     */
    protected mixed $clients;

    /**
     * @var mixed|string[]
     */
    protected mixed $headers;

    public function __construct()
    {
        $this->clients = new Client();
        $this->headers = [
            'Authorization' => 'Bearer ' . config('hemis.api_key'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command?->info('Seeding classifiers...');
        $this->classifiers();

        $this->command?->info('Seeding departments...');
        $this->departments();

        $this->command?->info('Seeding specialities...');
        $this->specialities();
    }

//      CLASSIFIERS SEEDER START
    public function classifiers(): void
    {
        $limit = config('hemis.limit');
        $host = config('hemis.host');
        $request = new Request('GET', "{$host}data/classifier-list?limit={$limit}", $this->headers);

        $res = $this->clients->sendAsync($request)->wait();
        $res = $res->getBody();
        $result = json_decode($res);

        if (!isset($result->success) || !$result->success) {
            // Agar success false bo‘lsa, baribir bitta urinish qilib ko‘ramiz
            $this->storeClassifierResult($result);
            return;
        }

        $totalPages = $result->data->pagination->pageCount ?? 1;

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i > 1) {
                $request = new Request('GET', "{$host}data/classifier-list?limit={$limit}&page={$i}", $this->headers);
                $res = $this->clients->sendAsync($request)->wait();
                $res = $res->getBody();
                $result = json_decode($res);
            }

            $this->storeClassifierResult($result);
            echo "    Classifier page: {$i}/{$totalPages} Stored" . PHP_EOL;
        }
    }

    protected function storeClassifierResult($result): void
    {
        if (!isset($result->data->items)) return;

        foreach (collect($result->data->items)->sortBy('id') as $item) {
            DB::beginTransaction();
            try {
                $classifier = Classifier::firstOrCreate(
                    ['classifier' => $item->classifier],
                    [
                        'name' => $item->name,
                        'version' => $item->version < 1 ? 1 : $item->version,
                    ]
                );

                foreach ($item->options ?? [] as $option) {
                    $classifier->options()->firstOrCreate(
                        ['code' => $option->code],
                        ['name' => $option->name]
                    );
                }

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                report($exception); // Laravel logger uchun
                throw $exception;   // yoki shunchaki continue; qilishingiz mumkin
            }
        }
    }
//      CLASSIFIERS SEEDER END

//    DEPARTMENTS SEEDER START
    public function departments()
    {
        $limit = config('hemis.limit');
        $host = config('hemis.host');
        $page = 1;

        do {
            $url = "{$host}data/department-list?limit={$limit}&page={$page}";
            $request = new Request('GET', $url, $this->headers);

            try {
                $res = $this->clients->sendAsync($request)->wait();
                $resBody = json_decode($res->getBody());

                $items = $resBody->data->items ?? [];
                foreach ($items as $item) {
                    Department::updateOrCreate(
                        ['id' => $item->id],
                        [
                            'parent_id'         => $item->parent,
                            'name'              => $item->name,
                            'code'              => $item->code,
                            'active'            => $item->active,
                            'h_structure_type'  => ClassifierOption::getId('structureType', $item->structureType?->code),
                            'h_locality_type'   => ClassifierOption::getId('localityType', $item->localityType?->code),
                        ]
                    );
                }

                $pageCount = $resBody->data->pagination->pageCount ?? 1;
                $page++;
            } catch (\Exception $e) {
                report($e); // Laravel log fayliga yozadi
                break; // xatolik bo‘lsa, tsiklni to‘xtatamiz
            }

        } while ($page <= $pageCount);
    }
//    DEPARTMENTS SEEDER END

//    SPECIALITY SEEDER START
    public function specialities()
    {
        $limit = config('hemis.limit', 100);
        $totalPages = 1; // Default, keyinchalik yangilanadi

// Avval 1-sahifani yuklaymiz va totalPages ni olamiz
        $url = config('hemis.host') . "data/specialty-list?limit={$limit}&page=1";
        $request = new Request('GET', $url, $this->headers);
        $response = $this->clients->sendAsync($request)->wait();
        $body = $response->getBody();
        $result = json_decode($body);

        if (!($result->success ?? false)) {
            Log::error('API javobi success=false bo‘ldi');
            return;
        }

// Total sahifalar sonini aniqlaymiz
        $pagination = $result->data->pagination;
        $totalPages = $pagination->pageCount ?? 1;

// 1-sahifadagi ma’lumotni saqlaymiz
        $items = collect($result->data->items ?? []);
        foreach ($items->sortBy('id') as $item) {
            DB::beginTransaction();
            try {
                Speciality::firstOrCreate([
                    'id' => $item->id,
                ], [
                    'code' => $item->code,
                    'name' => $item->name,
                    'department_id' => $item->department->id ?? null,
                    'h_locality_type' => ClassifierOption::getId('localityType', $item->localityType->code ?? null),
                    'h_education_type' => ClassifierOption::getId('educationType', $item->educationType->code ?? null),
                    'bachelor_specialty' => $item->bachelorSpecialty->code ?? null,
                    'master_specialty' => $item->masterSpecialty->code ?? null,
                    'doctorate_specialty' => $item->doctorateSpecialty->code ?? null,
                    'ordinature_specialty' => $item->ordinatureSpecialty->code ?? null,
                ]);
                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();
                Log::error("DB error on specialty ID: {$item->id}", ['exception' => $e]);
            }
        }

// Endi 2-sahifadan totalPages gacha yuklaymiz
        for ($page = 2; $page <= $totalPages; $page++) {
            $url = config('hemis.host') . "data/specialty-list?limit={$limit}&page={$page}";
            $request = new Request('GET', $url, $this->headers);

            try {
                $response = $this->clients->sendAsync($request)->wait();
                $body = $response->getBody();
                $result = json_decode($body);

                if (!($result->success ?? false)) {
                    break;
                }

                $items = collect($result->data->items ?? []);
                foreach ($items->sortBy('id') as $item) {
                    DB::beginTransaction();
                    try {
                        Speciality::firstOrCreate([
                            'id' => $item->id,
                        ], [
                            'code' => $item->code,
                            'name' => $item->name,
                            'department_id' => $item->department->id ?? null,
                            'h_locality_type' => ClassifierOption::getId('localityType', $item->localityType->code ?? null),
                            'h_education_type' => ClassifierOption::getId('educationType', $item->educationType->code ?? null),
                            'bachelor_specialty' => $item->bachelorSpecialty->code ?? null,
                            'master_specialty' => $item->masterSpecialty->code ?? null,
                            'doctorate_specialty' => $item->doctorateSpecialty->code ?? null,
                            'ordinature_specialty' => $item->ordinatureSpecialty->code ?? null,
                        ]);
                        DB::commit();
                    } catch (QueryException $e) {
                        DB::rollBack();
                        Log::error("DB error on specialty ID: {$item->id}", ['exception' => $e]);
                    }
                }

            } catch (\Exception $e) {
                Log::error("API xatosi sahifa {$page} da", ['exception' => $e]);
                break;
            }
        }
    }
//    SPECIALITY SEEDER END
}
