<?php

use App\Http\Controllers\Libraries\Bbks\BbkController;
use App\Http\Controllers\Libraries\Books\BookController;
use App\Http\Controllers\Libraries\Publishings\PublishingController;
use App\Http\Controllers\Libraries\Resources\ResourceTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//MAIN BUDXU UZ BILAN INTEGRATSIYA
Route::group(['prefix' => 'main', 'middleware' => 'jwt'], function (){

//    LIBRARIES ROUTES
    Route::group(['prefix' => 'libraries'], function (){
        Route::get('bbks',[BbkController::class,'paginate']);
        Route::get('bbk/all',[BbkController::class,'getAll']);
        Route::post('bbks',[BbkController::class,'store']);
        Route::put('bbks/{lib_bbk}/update',[BbkController::class,'update']);
        Route::delete('bbks/{lib_bbk}/delete',[BbkController::class,'delete']);

        Route::get('publishings',[PublishingController::class,'paginate']);
        Route::get('publishing/all',[PublishingController::class,'getAll']);
        Route::post('publishings',[PublishingController::class,'store']);
        Route::put('publishings/{lib_publishing}/update',[PublishingController::class,'update']);
        Route::delete('publishings/{lib_publishing}/delete',[PublishingController::class,'destroy']);

        Route::get('resource_types',[ResourceTypeController::class,'paginate']);
        Route::get('resource_type/all',[ResourceTypeController::class,'getAll']);
        Route::post('resource_types',[ResourceTypeController::class,'store']);
        Route::put('resource_types/{lib_reesource_type}/update',[ResourceTypeController::class,'update']);
        Route::delete('resource_types/{lib_reesource_type}/delete',[ResourceTypeController::class,'destroy']);

        Route::get('books',[BookController::class,'paginate']);
        Route::post('books',[BookController::class,'store']);
        Route::get('books/{book}/show',[BookController::class,'show']);
        Route::put('books/{book}/update',[BookController::class,'update']);
        Route::delete('books/{book}/delete',[BookController::class,'destroy']);
    });
//    LIBRARIES ROUTES END

});
