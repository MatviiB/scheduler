<?php

Route::group([
    'prefix' => config('scheduler.url'),
    'namespace' => 'MatviiB\\Scheduler\\Controllers',
    'middleware' => config('scheduler.middleware')], function () {

    $name = str_replace('/', '.', config('scheduler.url'));
    //
    Route::get('/', ['as' => "$name.index", 'uses' => 'SchedulerController@index']);

    Route::get('/edit/{task}', ['as' => "$name.edit", 'uses' => 'SchedulerController@edit']);

    Route::patch('/update/{task}', ['as' => "$name.update", 'uses' => 'SchedulerController@update']);

    Route::get('/toggle/{task}', ['as' => "$name.toggle", 'uses' => 'SchedulerController@toggle']);

    Route::get('/run/{task}', ['as' => "$name.run", 'uses' => 'SchedulerController@run']);

    Route::get('/create', ['as' => "$name.create", 'uses' => 'SchedulerController@create']);

    Route::post('/store', ['as' => "$name.store", 'uses' => 'SchedulerController@store']);

    Route::delete('/delete', ['as' => "$name.delete", 'uses' => 'SchedulerController@delete']);

});