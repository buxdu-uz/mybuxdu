<?php

namespace App\Http\Controllers\Libraries\Publishings;

use App\Domain\Libraries\Publishings\Repositories\LibraryPublishingRepository;
use App\Domain\Libraries\Publishings\Resources\PublishingResource;
use App\Http\Controllers\Controller;
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
}
