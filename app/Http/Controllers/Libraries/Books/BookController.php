<?php

namespace App\Http\Controllers\Libraries\Books;

use App\Domain\Libraries\Books\Repositories\LibraryBookRepository;
use App\Domain\Libraries\Books\Resources\BookResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * @var mixed|LibraryBookRepository
     */
    public mixed $books;

    /**
     * @param LibraryBookRepository $libraryBookRepository
     */
    public function __construct(LibraryBookRepository $libraryBookRepository)
    {
        $this->books = $libraryBookRepository;
    }

    public function paginate()
    {
        return BookResource::collection($this->books->paginate(\request()->query('pagination')));
    }
}
