<?php

namespace App\Http\Controllers\Libraries\Resources;

use App\Domain\Libraries\Resources\Repositories\LibraryResourceRepository;
use App\Domain\Libraries\Resources\Resources\ResourceResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * @var mixed|LibraryResourceRepository
     */
    public mixed $resources;

    /**
     * @param LibraryResourceRepository $libraryResourceRepository
     */
    public function __construct(LibraryResourceRepository $libraryResourceRepository)
    {
        $this->resources = $libraryResourceRepository;
    }

    public function paginate()
    {
        return ResourceResource::collection($this->resources->paginate(\request()->query('pagination')));
    }
}
