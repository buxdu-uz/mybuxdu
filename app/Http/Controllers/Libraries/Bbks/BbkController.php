<?php

namespace App\Http\Controllers\Libraries\Bbks;

use App\Domain\Libraries\Bbks\Actions\StoreBbkAction;
use App\Domain\Libraries\Bbks\Actions\UpdateBbkAction;
use App\Domain\Libraries\Bbks\DTO\StoreBbkDTO;
use App\Domain\Libraries\Bbks\DTO\UpdateBbkDTO;
use App\Domain\Libraries\Bbks\Models\LibBbk;
use App\Domain\Libraries\Bbks\Requests\BbkFilterRequest;
use App\Domain\Libraries\Bbks\Repositories\LibraryBbkRepository;
use App\Domain\Libraries\Bbks\Requests\StoreBbkRequest;
use App\Domain\Libraries\Bbks\Requests\UpdateBbkRequest;
use App\Domain\Libraries\Bbks\Resources\BbkResource;
use App\Filters\Bbks\BbkFilter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
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

    public function getAll(BbkFilterRequest $request)
    {
        $filter = app()->make(BbkFilter::class, ['queryParams' => array_filter($request->validated())]);
        return BbkResource::collection($this->bbks->getAll($filter));
    }

    /**
     * @param StoreBbkRequest $request
     * @param StoreBbkAction $action
     * @return JsonResponse
     */
    public function store(StoreBbkRequest $request, StoreBbkAction $action): JsonResponse
    {
        try {
            $dto = StoreBbkDTO::fromArray($request->validated());
            $response = $action->execute($dto);

            return $this->successResponse('Bbk muvaffaqiyatli yaratildi', new BbkResource($response));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    /**
     * @param UpdateBbkRequest $request
     * @param LibBbk $lib_bbk
     * @param UpdateBbkAction $action
     * @return JsonResponse
     */
    public function update(UpdateBbkRequest $request, LibBbk $lib_bbk,UpdateBbkAction $action): JsonResponse
    {
        try {
            $dto = UpdateBbkDTO::fromArray(array_merge($request->validated(),['lib_bbk' => $lib_bbk]));
            $response = $action->execute($dto);

            return $this->successResponse('Bbk muvaffaqiyatli tahrirlandi', new BbkResource($response));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function delete(LibBbk $lib_bbk)
    {
        $lib_bbk->delete();

        return $this->successResponse('Bbk muvaffaqiyatli o\'chirildi');
    }
}
