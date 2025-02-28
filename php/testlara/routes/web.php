<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(\App\Http\Controllers\RpcController::class)->group(function () {
    Route::get('/rpc/test','test');
});

Route::get('/rpcx',[\App\Http\Controllers\IndexController::class,'rpcx']);
Route::get('/http_rpcx',[\App\Http\Controllers\IndexController::class,'httpRpcx']);

Route::get('/welcome',function () {
    return Inertia::render('Welcome');
});
