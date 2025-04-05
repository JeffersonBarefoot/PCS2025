<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //    Very simple route that doesn't return an ID, and just shows the HelloWorld version'
//    Route::get('/positions', 'App\Http\Controllers\PositionController@show')->name('positions.show');

    // this passes the ID, but doesn't account for a default ID if none is passed
//        Route::get('/positions/{id?}',
//    'App\Http\Controllers\PositionController@show')
//            ->name('positions.show');

    //    passes ID.  If ID is not included (i.e. /positions instead of /positions/12345) the the default ID of 9999999999 is passed and can be a trigger
    Route::get('/positions', 'App\Http\Controllers\PositionController@shownoid')->name('positions.shownoid');
    Route::get('/positions/{id?}', 'App\Http\Controllers\PositionController@show')->name('positions.show');

    Route::get('/incumbents', 'App\Http\Controllers\IncumbentController@shownoid')->name('incumbents.shownoid');
    Route::get('/incumbents/{id?}', 'App\Http\Controllers\IncumbentController@show')->name('incumbents.show');

    Route::post('/uploadfile',     'App\Http\Controllers\UploadFileController@uploadfile')->name('uploadfile');


//    Route::post('/update-collapse-status', 'App\Http\Controllers\PositionController@updateCollapseStatus')->name('updateCollapseStatus');
    Route::post('/update-collapse-status', 'App\Http\Controllers\PositionController@updateCollapseStatus')->name('updateCollapseStatus');
});
