<?php

namespace Database\Seeders;

use App\Domain\Classifiers\Models\Classifier;
use App\Domain\Classifiers\Models\ClassifierOption;
use App\Domain\Departments\Models\Department;
use App\Domain\Specialities\Models\Speciality;
use App\Models\User;
use App\Models\UserProfile;
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

        $this->command?->info('Seeding employees...');
        $this->employees();
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
                            'parent_id' => $item->parent,
                            'name' => $item->name,
                            'code' => $item->code,
                            'active' => $item->active,
                            'h_structure_type' => ClassifierOption::getId('structureType', $item->structureType?->code),
                            'h_locality_type' => ClassifierOption::getId('localityType', $item->localityType?->code),
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
        $request = new Request('GET', config('hemis.host').'data/specialty-list?limit='.config('hemis.limit'), $this->headers);
        $res = $this->clients->sendAsync($request)->wait();
        $res = $res->getBody();
        $result = json_decode($res);
        if ($result->success === true) {
            foreach (collect($result->data->items)->sortBy('id') as $item) {
                DB::beginTransaction();
                try {
                    Speciality::updateOrCreate([
                        'id' => $item->id,
                    ], [
                        'code' => $item->code,
                        'name' => $item->name,
                        'department_id' => $item->department?->id ?? null,
                        'h_locality_type' => ClassifierOption::getId('localityType', $item->localityType->code),
                        'h_education_type' => ClassifierOption::getId('educationType', $item->educationType->code),
                        'h_bachelor_speciality' => $item->bachelorSpecialty != null ? $item->bachelorSpecialty->code : null,
                        'h_master_speciality' => $item->masterSpecialty != null ? $item->masterSpecialty->code : null,
                        'doctorate_speciality' => $item->doctorateSpecialty != null ? $item->doctorateSpecialty->code : null,
                        'h_speciality_ordinatura' => $item->ordinatureSpecialty != null ? $item->ordinatureSpecialty->code : null,
                    ]);
                    DB::commit();
                } catch (QueryException $exception) {
                    DB::rollBack();
                    throw $exception;
                }
            }
        }
    }
//    SPECIALITY SEEDER END

//    EMPLOYEE SEEDER START
    public function employees()
    {
        $page = 1;
        $pageCount = 1;

        do {
            $request = new Request(
                'GET',
                config('hemis.host') . 'data/employee-list?type=all&limit=' . config('hemis.limit') . '&page=' . $page,
                $this->headers
            );

            $res = $this->clients->sendAsync($request)->wait();
            $resBody = json_decode($res->getBody());

            if (isset($resBody->data->items)) {
                foreach ($resBody->data->items as $item) {
                    $this->handleEmployeeItem($item);
                }
            }

            $pageCount = $resBody->data->pagination->pageCount ?? 1;
            $page++;

        } while ($page <= $pageCount);
    }

    private function handleEmployeeItem($item)
    {
        $user = User::updateOrCreate(
            [
                'id' => $item->id,
                'employee_id_number' => $item->employee_id_number,
            ],
            [
                'login' => $item->employee_id_number,
                'full_name' => $item->full_name,
                'avatar' => $item->image,
                'password' => $item->employee_id_number,
            ]
        );

        $departmentId = Department::getIdByCode(optional($item->department)->code);
        $genderId = ClassifierOption::getId('gender', optional($item->gender)->code);
        $degreeId = ClassifierOption::getId('academicDegree', optional($item->academicDegree)->code);
        $rankId = ClassifierOption::getId('academicRank', optional($item->academicRank)->code);
        $employmentFormId = ClassifierOption::getId('employmentForm', optional($item->employmentForm)->code);
        $employmentStaffId = ClassifierOption::getId('employmentStaff', optional($item->employmentStaff)->code);
        $staffPositionId = ClassifierOption::getId('teacherPositionType', optional($item->staffPosition)->code);
        $employeeStatusId = ClassifierOption::getId('employeeType', optional($item->employeeStatus)->code);
        $employeeTypeId = ClassifierOption::getId('employeeType', optional($item->employeeType)->code);

        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'department_id' => $departmentId,
                'full_name' => $item->full_name,
                'short_name' => $item->short_name,
                'first_name' => $item->first_name,
                'second_name' => $item->second_name,
                'third_name' => $item->third_name,
                'year_of_enter' => $item->year_of_enter,
                'h_gender' => $genderId,
                'h_academic_degree' => $degreeId,
                'h_academic_rank' => $rankId,
                'h_employment_form' => $employmentFormId,
                'h_employment_staff' => $employmentStaffId,
                'h_staff_position' => $staffPositionId,
                'h_employee_status' => $employeeStatusId,
                'h_employee_type' => $employeeTypeId,
                'birth_date' => isset($item->birth_date) ? date('Y-m-d', $item->birth_date) : null,
                'contract_number' => $item->contract_number,
                'decree_number' => $item->decree_number,
                'contract_date' => isset($item->contract_date) ? date('Y-m-d', $item->contract_date) : null,
                'decree_date' => isset($item->decree_date) ? date('Y-m-d', $item->decree_date) : null,
                'hash' => $item->hash,
                'tutorGroups' => json_encode($item->tutorGroups),
            ]
        );

        $user->assignRole('guest');
    }
//    EMPLOYEE SEEDER END
}
