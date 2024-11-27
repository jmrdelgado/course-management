<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    /* return view('welcome'); */
    return redirect('/adminpanel');
});

Route::get('/launchnotification', function() {
    Artisan::call('queue:work --tries=3 --stop-when-empty');
});

Route::get('/optimize', function() {
    Artisan::call('optimize');
});

Route::get('/notptimize', function() {
    Artisan::call('optimize:clear');
});

Route::get('/deploy', function () {
    Artisan::call('key:generate');
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('migrate:refresh');
    Artisan::call('shield:generate --all');
    Artisan::call('db:seed');
});
