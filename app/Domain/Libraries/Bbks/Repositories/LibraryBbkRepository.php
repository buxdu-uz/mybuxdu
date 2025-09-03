<?php

namespace App\Domain\Libraries\Bbks\Repositories;

use App\Domain\Libraries\Bbks\Models\LibBbk;

class LibraryBbkRepository
{
    public function paginate($pagination)
    {
        return LibBbk::query()
            ->whereNull('sub_id')
            ->orderBy('name')
            ->paginate($pagination);
    }
}
