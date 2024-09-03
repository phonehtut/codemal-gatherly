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

Route::post('/event/create', [EventController::class, 'store'])->name('events.store');
//End Event Route

//Start Form Route
Route::post('/event/{event:id}/form', [\App\Http\Controllers\Api\FormController::class, 'index'])->name('events.form');

Route::get('/form/data/{event:id}', [EventController::class, 'formData'])->name('form.data');
//End Form Route

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

