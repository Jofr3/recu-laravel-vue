<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerProducts;
use App\Http\Controllers\ControllerUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(Controller::class)->group(function () {
    Route::get('/works', 'works');
});

Route::controller(ControllerUsers::class)->group(function () {
    Route::get('/users/all', 'all');
    Route::post('/users/add', 'add');
    Route::delete('/users/del/{id}', 'del');
    Route::put('/users/edit/{id}', 'edit');
});

Route::controller(ControllerProducts::class)->group(function () {
    Route::get('/products/all', 'all');
    Route::post('/products/add', 'add');
    Route::delete('/products/del/{id}', 'del');
    Route::put('/products/edit/{id}', 'edit');
});
