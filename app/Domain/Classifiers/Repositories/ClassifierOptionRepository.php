<?php

namespace App\Domain\Classifiers\Repositories;

use App\Domain\Classifiers\Models\ClassifierOption;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClassifierOptionRepository
{
    /**
     * @param $pagination
     * @return LengthAwarePaginator
     */
    public function paginate($pagination): LengthAwarePaginator
    {
        return ClassifierOption::query()
            ->orderBy('name')
            ->paginate($pagination);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return ClassifierOption::query()
            ->get()
            ->sortBy('name');
    }
}
