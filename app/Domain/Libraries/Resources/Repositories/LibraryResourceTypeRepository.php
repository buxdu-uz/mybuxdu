<?php

namespace App\Domain\Libraries\Resources\Repositories;

use App\Domain\Libraries\Bbks\Models\LibBbk;
use App\Domain\Libraries\Publishings\Models\LibPublishing;
use App\Domain\Libraries\Resources\Models\LibResourceType;

class LibraryResourceTypeRepository
{
    public function paginate($pagination)
    {
        return LibResourceType::query()
            ->orderBy('name')
            ->paginate($pagination);
    }
}
