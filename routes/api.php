<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Classifiers\ClassifierController;
use App\Http\Controllers\Departments\DepartmentController;
use App\Http\Controllers\Libraries\Bbks\BbkController;
use App\Http\Controllers\Libraries\Books\BookController;
use App\Http\Controllers\Libraries\Publishings\PublishingController;
use App\Http\Controllers\Libraries\Resources\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('me',[AuthController::class, 'me']);
    Route::post('logout',[AuthController::class, 'logout']);

//    CLASSIFIERS API START
    Route::get('classifiers', [ClassifierController::class, 'paginateClassifier']);
    Route::get('classifier_options', [ClassifierController::class, 'paginateClassifierOption']);
//    CLASSIFIERS API END

//    DEPARTMENTS API START
    Route::get('departments', [DepartmentController::class, 'paginate']);
    Route::get('department/all', [DepartmentController::class, 'getAll']);
//    DEPARTMENTS API END

});



//MAIN BUDXU UZ BILAN INTEGRATSIYA

Route::group(['prefix' => 'main'], function (){

//    LIBRARIES ROUTES
    Route::group(['prefix' => 'libraries'], function (){
        Route::get('bbks',[BbkController::class,'paginate']);
        Route::get('publishings',[PublishingController::class,'paginate']);
        Route::get('resources',[ResourceController::class,'paginate']);
        Route::get('books',[BookController::class,'paginate']);
    });
//    LIBRARIES ROUTES END

});
