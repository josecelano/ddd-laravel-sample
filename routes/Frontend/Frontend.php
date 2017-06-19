<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', 'FrontendController@index')->name('index');
Route::get('macros', 'FrontendController@macros')->name('macros');

Route::group(['namespace' => 'Appliance'], function () {
    Route::get('dishwashers', 'ApplianceController@dishwashers')->name('dishwashers');
    Route::get('small-appliances', 'ApplianceController@smallAppliances')->name('small.appliances');
});

Route::group(['namespace' => 'User'], function () {
    Route::get('{userId}/wishlist', 'WishlistController@index')->name('wishlist');
});

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('account', 'AccountController@index')->name('account');
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');
        Route::post('{userId}/wishlist/add-appliance', 'WishlistController@addAppliance')->name('wishlist.appliance.add');
        Route::post('{userId}/wishlist/remove-appliance', 'WishlistController@removeAppliance')->name('wishlist.appliance.remove');
    });
});