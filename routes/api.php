<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


//Start Event Route
Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::get('/events/lastest', [EventController::class, 'lastestEvents'])->name('events.lastest');

Route::get('/events/{id}', [EventController::class, 'detail'])->name('events.detail');
//End Event Route

//Star Admin Route

Route::get('/ratins',[RatingController::class,'index'])->name('ratings.index');


//End Admin Route

//Start Category Route
Route::get('/categories',[CategoryController::class],'index')->name('categories.index');

//End Category Route