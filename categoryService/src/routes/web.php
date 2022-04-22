<?php

use Illuminate\Support\Facades\Route;

// TODO Do not use string (admin permission)
Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'permission:admin']], function () {
    Route::post('categories', [
        'uses' => 'CategoryController@store',
        'as' => 'v1.categories.store',
    ]);
    Route::put('categories/{categoryId}', [
        'uses' => 'CategoryController@update',
        'as' => 'v1.categories.update',
    ]);
    Route::delete('categories/{categoryId}', [
        'uses' => 'CategoryController@destroy',
        'as' => 'v1.categories.destroy',
    ]);
});

Route::group(['prefix' => 'v1',], function () {
    Route::get('categories', [
        'uses' => 'CategoryController@index',
        'as' => 'v1.categories.index',
    ]);
    Route::get('categories/{categoryId}', [
        'uses' => 'CategoryController@show',
        'as' => 'v1.categories.show',
    ]);
});
