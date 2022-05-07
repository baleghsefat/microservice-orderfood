<?php

use Illuminate\Support\Facades\Route;

// TODO Do not use string (admin permission)
Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'permission:admin']], function () {
    Route::post('restaurants', [
        'uses' => 'RestaurantController@store',
        'as' => 'v1.restaurants.store',
    ]);
    Route::put('restaurants/{restaurantId}', [
        'uses' => 'RestaurantController@update',
        'as' => 'v1.restaurants.update',
    ]);
    Route::delete('restaurants/{restaurantId}', [
        'uses' => 'RestaurantController@destroy',
        'as' => 'v1.restaurants.destroy',
    ]);
    Route::put('restaurants/{restaurantId}/users', [
        'uses' => 'SyncRestaurantUsersController',
        'as' => 'v1.restaurants.users.update',
    ]);
});

Route::group(['prefix' => 'v1',], function () {
    Route::get('restaurants', [
        'uses' => 'RestaurantController@index',
        'as' => 'v1.restaurants.index',
    ]);
    Route::get('restaurants/{restaurantId}', [
        'uses' => 'RestaurantController@show',
        'as' => 'v1.restaurants.show',
    ]);
});
