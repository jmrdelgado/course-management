<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    /* return view('welcome'); */
    return redirect('/adminpanel');
});

Route::get('/optimize', function() {
    Artisan::call('optimize');
});

Route::get('/notptimize', function() {
    Artisan::call('optimize:clear');
});
