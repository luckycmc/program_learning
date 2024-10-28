<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(\App\Http\Controllers\RpcController::class)->group(function () {
    Route::get('/rpc/test','test');
});
