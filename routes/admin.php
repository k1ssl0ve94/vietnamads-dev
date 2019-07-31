<?php

// Route::get('auth/google', 'AuthController@google');
// Route::get('auth/google/callback', 'AuthController@googleCallback');

// Route::get('/', function() {
//     return "abc";
// });

Route::get('/{any?}', function () {
    return view('admin.app');
})->where('any', '.*');