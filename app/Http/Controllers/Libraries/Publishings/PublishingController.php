<?php

namespace App\Http\Controllers\Libraries\Publishings;

use App\Domain\Libraries\Publishings\Actions\StorePublishingAction;
use App\Domain\Libraries\Publishings\Actions\UpdatePublishingAction;
use App\Domain\Libraries\Publishings\DTO\StorePublishingDTO;
use App\Domain\Libraries\Publishings\DTO\UpdatePublishingDTO;
use App\Domain\Libraries\Publishings\Models\LibPublishing;
use App\Domain\Libraries\Publishings\Repositories\LibraryPublishingRepository;
use App\Domain\Libraries\Publishings\Requests\StoreLibPublishingRequest;
use App\Domain\Libraries\Publishings\Requests\UpdateLibPublishingRequest;
use App\Domain\Libraries\Publishings\Resources\PublishingResource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class PublishingController extends Controller
{
    /**
     * @var mixed|LibraryPublishingRepository
     */
    public mixed $publishings;

    /**
     * @param LibraryPublishingRepository $libraryPublishingRepository
     */
    public function __construct(LibraryPublishingRepository $libraryPublishingRepository)
    {
        $this->publishings = $libraryPublishingRepository;
    }

    public function paginate()
    {
        return PublishingResource::collection($this->publishings->paginate(\request()->query('pagination')));
    }

    public function getAll()
    {
        return PublishingResource::collection($this->publishings->getAll());
    }

    public function store(StoreLibPublishingRequest $request, StorePublishingAction $action)
    {
        try {
            $dto = StorePublishingDTO::fromArray($request->validated());
            $response = $action->execute($dto);

            return $this->successResponse('Publishing created successfully', new PublishingResource($response));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function update(UpdateLibPublishingRequest $request, LibPublishing $lib_publishing,UpdatePublishingAction $action)
    {
        try {
            $dto = UpdatePublishingDTO::fromArray(array_merge($request->validated(), ['lib_publishing' => $lib_publishing]));
            $response = $action->execute($dto);

            return $this->successResponse('Publishing updated successfully', new PublishingResource($response));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function destroy(LibPublishing $lib_publishing)
    {
        try {
            $lib_publishing->delete();
            return $this->successResponse('Publishing deleted successfully');
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
