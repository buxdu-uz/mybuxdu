<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('error.404');
});
