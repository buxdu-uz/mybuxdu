<?php

namespace App\Http\Controllers\Libraries\Books;

use App\Domain\Libraries\Books\Actions\StoreLibBookAction;
use App\Domain\Libraries\Books\Actions\UpdateLibBookAction;
use App\Domain\Libraries\Books\DTO\StoreLibBookDTO;
use App\Domain\Libraries\Books\DTO\UpdateLibBookDTO;
use App\Domain\Libraries\Books\Models\LibBook;
use App\Domain\Libraries\Books\Repositories\LibraryBookRepository;
use App\Domain\Libraries\Books\Requests\StoreLibBookRequest;
use App\Domain\Libraries\Books\Requests\UpdateLibBookRequest;
use App\Domain\Libraries\Books\Resources\BookResource;
use App\Http\Controllers\Controller;
use Exception;
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

    public function store(StoreLibBookRequest $request, StoreLibBookAction $action)
    {
        try {
            $dto = StoreLibBookDTO::fromArray($request->validated());
            $response = $action->execute($dto);

            return $this->successResponse('Книга успешно создана', new BookResource($response));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function show(LibBook $book)
    {
        try {
            return $this->successResponse('Книга успешно получена', new BookResource($book));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function update(UpdateLibBookRequest $request, LibBook $book,UpdateLibBookAction $action)
    {
        try {
            $dto = UpdateLibBookDTO::fromArray(array_merge($request->validated(),['lib_book' => $book]));
            $response = $action->execute($dto);

            return $this->successResponse('Книга успешно update', new BookResource($response));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function destroy(LibBook $book)
    {
        try {
            $book->delete();

            return $this->successResponse('Книга успешно удалена');
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
