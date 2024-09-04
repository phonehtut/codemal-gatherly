<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


//Start Event Route
Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::get('/events/lastest', [EventController::class, 'lastestEvents'])->name('events.lastest');

Route::get('/event/{id}', [EventController::class, 'detail'])->name('events.detail');


//Event Search with title and category
Route::get('/events/search/', [EventController::class, 'search'])->name('events.search');

//End Event Route

//Start Auth Route
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('password/email', [AuthController::class, 'forgotPassword']);
Route::post('password/reset', [AuthController::class, 'resetPassword']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
});
//End Auth Route

//Start Rating Route
Route::post('/event/{event:id}/rating', [RatingController::class, 'store']);

//End Rating Route

//Start Category Route

Route::get('/categories',[CategoryController::class,'index'])->name('categories.index');
Route::post('/categories/create',[CategoryController::class,'createcategory'])->name('categories.create');
Route::put('/categories/update/{category:id}',[CategoryController::class,'updatecategory'])->name('categories.update');
//End Category Route

