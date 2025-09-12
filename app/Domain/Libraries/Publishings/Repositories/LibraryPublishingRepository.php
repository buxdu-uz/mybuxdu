<?php

namespace App\Domain\Libraries\Publishings\Repositories;

use App\Domain\Libraries\Bbks\Models\LibBbk;
use App\Domain\Libraries\Publishings\Models\LibPublishing;

class LibraryPublishingRepository
{
    public function paginate($pagination)
    {
        return LibPublishing::query()
            ->orderByDesc('created_at')
            ->paginate($pagination);
    }

    public function getAll()
    {
        return LibPublishing::query()
            ->get()
            ->sortBy('name');
    }
}
