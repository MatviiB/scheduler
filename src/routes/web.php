<?php

Route::group([ 'namespace' => 'MatviiB\\Scheduler\\Controllers',
    'middleware' => config('scheduler.middleware')], function () {

    $url = config('scheduler.url');
    $name = str_replace('/', '.', $url);
    //
    Route::get($url, ['as' => "$name.index", 'uses' => "SchedulerController@index"]);

    Route::get("$url/edit/{task}", ['as' => "$name.edit", 'uses' => "SchedulerController@edit"]);

    Route::patch("$url/update/{task}", ['as' => "$name.update", 'uses' =>  "SchedulerController@update"]);

    Route::get("$url/toggle/{task}", ['as' => "$name.toggle", 'uses' => "SchedulerController@toggle"]);

    Route::get("$url/run/{task}", ['as' => "$name.run", 'uses' => "SchedulerController@run"]);

    Route::get("$url/create", ['as' => "$name.create", 'uses' => "SchedulerController@create"]);

    Route::post("$url/store", ['as' => "$name.store", 'uses' => "SchedulerController@store"]);

    Route::delete("$url/delete", ['as' => "$name.delete", 'uses' => "SchedulerController@delete"]);

});