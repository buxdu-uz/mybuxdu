<?php

namespace App\Http\Controllers\Classifiers;

use App\Domain\Classifiers\Repositories\ClassifierOptionRepository;
use App\Domain\Classifiers\Repositories\ClassifierRepository;
use App\Domain\Classifiers\Resources\ClassifierOptionResource;
use App\Domain\Classifiers\Resources\ClassifierResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClassifierController extends Controller
{
    /**
     * @var mixed|ClassifierRepository
     */
    public mixed $classifiers;

    /**
     * @var mixed|ClassifierOptionRepository
     */
    public mixed $classifierOptions;

    /**
     * @param ClassifierRepository $classifierRepository
     * @param ClassifierOptionRepository $classifierOptionRepository
     */
    public function __construct(ClassifierRepository $classifierRepository, ClassifierOptionRepository $classifierOptionRepository)
    {
        $this->classifiers = $classifierRepository;
        $this->classifierOptions = $classifierOptionRepository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function paginateClassifier(): AnonymousResourceCollection
    {
        return ClassifierResource::collection($this->classifiers->paginate(\request()->query('pagination',20)));
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function paginateClassifierOption(): AnonymousResourceCollection
    {
        return ClassifierOptionResource::collection($this->classifierOptions->paginate(\request()->query('pagination',20)));
    }
}
