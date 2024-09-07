<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


//Start Category Route

Route::get('/categories', [CategoryController::class, 'index']);

//End Category Route

//Start Event Route
Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::get('/events/lastest', [EventController::class, 'latestEvents'])->name('events.lastest');

Route::get('/event/{id}', [EventController::class, 'detail'])->name('events.detail');

// Show Event with category
Route::get('/category/{category:id}/events', [EventController::class, 'categoryEvents'])->name('events.categoryEvents');
//End Event Route

//Event Search with title and category
Route::get('/events/search/', [EventController::class, 'search'])->name('events.search');

// Change Route Login not defind error message
Route::get('/error', [AuthController::class, 'error'])->name('login');

//Start Auth Route
Route::post('register', [AuthController::class, 'register'])->name('sigin_up');
Route::post('login', [AuthController::class, 'login'])->name('sigin_in');
Route::post('password/email', [AuthController::class, 'forgotPassword']);
Route::post('password/reset', [AuthController::class, 'resetPassword']);
//End Auth Route

Route::middleware('auth:api')->group(function () {

    //Create Event
    Route::post('/event/create', [EventController::class, 'store'])->name('events.store');

    // Show my events
    Route::get('/my_events', [EventController::class, 'myEvents'])->name('events.myEvents');

    // Update My Event Data
    Route::put('/event/{event:id}/update', [EventController::class, 'update'])->name('events.update');

    //Delete my event
    Route::delete('/event/{id}/delete', [EventController::class, 'destroy'])->name('events.destroy');

    // Event Register Form
    Route::post('/event/{event:id}/form', [\App\Http\Controllers\Api\FormController::class, 'index'])->name('events.form');

    //Show FormData with event id
    Route::get('/form/data/{event:id}', [EventController::class, 'formData'])->name('form.data');

    // Fill Rating
    Route::post('/event/{event:id}/rating', [RatingController::class, 'store']);

    // Show My History
    Route::get('/my_history', [HistoryController::class, 'myHistory']);

    // LogoutC
    Route::post('logout', [AuthController::class, 'logout']);

    /// My Profile
    Route::get('profile', [AuthController::class, 'profile']);

});
//End Auth Route

//Start Search Histories Route

Route::get('/event/histories/search',[HistoryController::class,'searchhistory']);

//End Search Histories Route

