<?php

namespace App\Domain\Libraries\Resources\Repositories;

use App\Domain\Libraries\Bbks\Models\LibBbk;
use App\Domain\Libraries\Publishings\Models\LibPublishing;
use App\Domain\Libraries\Resources\Models\LibResource;

class LibraryResourceRepository
{
    public function paginate($pagination)
    {
        return LibResource::query()
            ->orderBy('name')
            ->paginate($pagination);
    }
}
