<?php

use Illuminate\Support\Facades\Route;

Route::get('create', 'ConnectController@create')->name('create');

Route::get('create/callback', 'ConnectController@createCallback')->name('create.callback');

Route::post('close', 'ConnectController@close')->name('close');