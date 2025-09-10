<?php

namespace App\Http\Controllers\Libraries\Bbks;

use App\Domain\Libraries\Bbks\Requests\BbkFilterRequest;
use App\Domain\Libraries\Bbks\Repositories\LibraryBbkRepository;
use App\Domain\Libraries\Bbks\Resources\BbkResource;
use App\Filters\Bbks\BbkFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BbkController extends Controller
{
    /**
     * @var mixed|LibraryBbkRepository
     */
    public mixed $bbks;

    /**
     * @param LibraryBbkRepository $libraryBbkRepository
     */
    public function __construct(LibraryBbkRepository $libraryBbkRepository)
    {
        $this->bbks = $libraryBbkRepository;
    }

    public function paginate(BbkFilterRequest $request)
    {
        $filter = app()->make(BbkFilter::class, ['queryParams' => array_filter($request->validated())]);
        return BbkResource::collection($this->bbks->paginate(\request()->query('pagination',10),$filter));
    }
}
