<?php

namespace App\Domain\Libraries\Bbks\Repositories;

use App\Domain\Libraries\Bbks\Models\LibBbk;

class LibraryBbkRepository
{
    public function paginate($pagination,$filter)
    {
        return LibBbk::query()
            ->withCount('resources')
            ->Filter($filter)
            ->paginate($pagination);
    }

    public function getAll($filter)
    {
        return LibBbk::query()
            ->Filter($filter)
            ->get()
            ->sortBy('name');
    }
}
