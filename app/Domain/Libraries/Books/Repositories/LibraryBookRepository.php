<?php
namespace App\Domain\Libraries\Books\Repositories;

use App\Domain\Libraries\Books\Models\LibBook;

class LibraryBookRepository
{
    public function paginate($pagination)
    {
        return LibBook::query()
//            ->orderByDesc('created_at')
            ->paginate($pagination);
    }
}
