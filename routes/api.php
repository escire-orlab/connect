<?php

use Illuminate\Support\Facades\Route;

Route::post('close/callback', 'ConnectController@closeCallback')->name('close.callback');