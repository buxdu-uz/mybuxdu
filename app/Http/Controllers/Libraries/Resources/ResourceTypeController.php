<?php

namespace App\Http\Controllers\Libraries\Resources;

use App\Domain\Libraries\Resources\Repositories\LibraryResourceTypeRepository;
use App\Domain\Libraries\Resources\Resources\ResourceTypeResource;
use App\Http\Controllers\Controller;
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
}
