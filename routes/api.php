<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'API'], function () {
    Route::prefix('contacts')->group(function () {
        Route::get('', 'ContactsController@index')->name('contacts.all');
        Route::get('/{id}', 'ContactsController@show')->name('contacts.show');
        Route::post('', 'ContactsController@store')->name('contacts.post');
    });

    Route::get('/attachments/{id}', 'AttachmentsController@show')->name('file.show');
});

