<?php

Route::group(['middleware' => config('scheduler.middleware')], function () {
    $url = config('scheduler.url');
    $controller = 'MatviiB\\Scheduler\\Controllers\\SchedulerController';
    //
    Route::get($url, ['as' => "$url.index", 'uses' => "$controller@index"]);

    Route::get("$url/edit/{task}", ['as' => "$url.edit", 'uses' => "$controller@edit"]);

    Route::patch("$url/update/{task}", ['as' => "$url.update", 'uses' =>  "$controller@update"]);

    Route::get("$url/toggle/{task}", ['as' => "$url.toggle", 'uses' => "$controller@toggle"]);

    Route::get("$url/run/{task}", ['as' => "$url.run", 'uses' => "$controller@run"]);

    Route::get("$url/create", ['as' => "$url.create", 'uses' => "$controller@create"]);

    Route::post("$url/store", ['as' => "$url.store", 'uses' => "$controller@store"]);

    Route::delete("$url/delete", ['as' => "$url.delete", 'uses' => "$controller@delete"]);

});