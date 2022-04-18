<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'User'], function () {
    Route::post('login', [
        'uses' => 'AuthController@login',
        'as' => 'v1.login',
    ]);
});
