<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Classifiers\ClassifierController;
use App\Http\Controllers\Departments\DepartmentController;
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
