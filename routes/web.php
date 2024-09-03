<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('welcome');
});



//Route::get('/test-email', function () {
//    $details = [
//        'subject' => 'Test Email',
//        'body' => 'This is a test email sent from Laravel.'
//    ];
//
//    Mail::raw($details['body'], function ($message) use ($details) {
//        $message->to('phonehtutkhaung.dev@gmail.com')
//            ->subject($details['subject']);
//    });
//
//    return 'Test email sent!';
//});
