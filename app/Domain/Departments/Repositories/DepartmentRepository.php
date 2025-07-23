<?php

namespace App\Domain\Departments\Repositories;

use App\Domain\Departments\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentRepository
{
    /**
     * @param $pagination
     * @return LengthAwarePaginator
     */
    public function paginate($pagination): LengthAwarePaginator
    {
        return Department::query()
            ->orderBy('name')
            ->paginate($pagination);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Department::query()
            ->get()
            ->sortBy('name');
    }
}
