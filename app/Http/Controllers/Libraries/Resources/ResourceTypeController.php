<?php

namespace App\Http\Controllers\Libraries\Resources;

use App\Domain\Libraries\Resources\Actions\StoreLibResourceTypeAction;
use App\Domain\Libraries\Resources\Actions\UpdateLibResourceTypeAction;
use App\Domain\Libraries\Resources\DTO\StoreLibResourceTypeDTO;
use App\Domain\Libraries\Resources\DTO\UpdateLibResourceTypeDTO;
use App\Domain\Libraries\Resources\Models\LibResourceType;
use App\Domain\Libraries\Resources\Repositories\LibraryResourceTypeRepository;
use App\Domain\Libraries\Resources\Requests\StoreLibResourceTypeRequest;
use App\Domain\Libraries\Resources\Requests\UpdateLibResourceTypeRequest;
use App\Domain\Libraries\Resources\Resources\ResourceTypeResource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ResourceTypeController extends Controller
{
    /**
     * @var mixed|LibraryResourceTypeRepository
     */
    public mixed $resources;

    /**
     * @param LibraryResourceTypeRepository $libraryResourceRepository
     */
    public function __construct(LibraryResourceTypeRepository $libraryResourceRepository)
    {
        $this->resources = $libraryResourceRepository;
    }

    public function paginate()
    {
        return ResourceTypeResource::collection($this->resources->paginate(\request()->query('pagination')));
    }

    public function getAll()
    {
        return ResourceTypeResource::collection($this->resources->getAll());
    }

    public function store(StoreLibResourceTypeRequest $request, StoreLibResourceTypeAction $action)
    {
        try {
            $dto = StoreLibResourceTypeDTO::fromArray($request->validated());
            $response = $action->execute($dto);

            return $this->successResponse('Resource type created successfully', new ResourceTypeResource($response));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function update(UpdateLibResourceTypeRequest $request, LibResourceType $lib_resource_type,UpdateLibResourceTypeAction $action)
    {
        try {
            $dto = UpdateLibResourceTypeDTO::fromArray(array_merge($request->validated(), ['lib_resource_type' => $lib_resource_type]));
            $response = $action->execute($dto);

            return $this->successResponse('Publishing updated successfully', new ResourceTypeResource($response));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function destroy(LibResourceType $lib_resource_type)
    {
        try {
            $lib_resource_type->delete();
            return $this->successResponse('Resource type deleted successfully');
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
