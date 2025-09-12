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
        Route::post('bbks',[BbkController::class,'store']);
        Route::put('bbks/{lib_bbk}/update',[BbkController::class,'update']);
        Route::delete('bbks/{lib_bbk}/delete',[BbkController::class,'delete']);
        Route::get('publishings',[PublishingController::class,'paginate']);
        Route::get('resource_types',[ResourceTypeController::class,'paginate']);
        Route::get('books',[BookController::class,'paginate']);
        Route::post('books',[BookController::class,'store']);
        Route::put('books/{book}/update',[BookController::class,'update']);
        Route::delete('books/{book}/delete',[BookController::class,'destroy']);
    });
//    LIBRARIES ROUTES END

});
