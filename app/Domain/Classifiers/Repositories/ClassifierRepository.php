<?php

namespace App\Domain\Classifiers\Repositories;

use App\Domain\Classifiers\Models\Classifier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClassifierRepository
{
    /**
     * @param $pagination
     * @return LengthAwarePaginator
     */
    public function paginate($pagination): LengthAwarePaginator
    {
        return Classifier::query()
            ->orderBy('name')
            ->paginate($pagination);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Classifier::query()
            ->get()
            ->sortBy('name');
    }
}
