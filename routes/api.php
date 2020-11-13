<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'API'], function () {
    Route::prefix('contacts')->group(function () {
        Route::get('', 'ContactsController@index');
        Route::get('/{id}', 'ContactsController@show');
        Route::post('', 'ContactsController@store');
        Route::put('/{id}', 'ContactsController@update');
        Route::delete('/{id}', 'ContactsController@destroy');
    });

    Route::get('/attachments/{id}', 'AttachmentsController@show')->name('file.show');
});

