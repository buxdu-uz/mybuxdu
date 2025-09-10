<?php

use App\Http\Controllers\Libraries\Bbks\BbkController;
use App\Http\Controllers\Libraries\Books\BookController;
use App\Http\Controllers\Libraries\Publishings\PublishingController;
use App\Http\Controllers\Libraries\Resources\ResourceController;
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
        Route::get('resources',[ResourceController::class,'paginate']);
        Route::get('books',[BookController::class,'paginate']);
    });
//    LIBRARIES ROUTES END

});
