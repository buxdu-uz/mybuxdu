<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum','role:admin']], function () {

});
