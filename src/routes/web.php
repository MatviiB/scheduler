<?php

$name = config('scheduler.name');

Route::group([
    'prefix' => config('scheduler.url'),
    'namespace' => 'MatviiB\\Scheduler\\Controllers',
    'middleware' => config('scheduler.middleware')
], function () use ($name) {

    Route::get('/', "SchedulerController@index")->name("$name.index");

    Route::get("/edit/{task}", "SchedulerController@edit")->name("$name.edit");

    Route::patch("/update/{task}", "SchedulerController@update")->name("$name.update");

    Route::get("/toggle/{task}", "SchedulerController@toggle")->name("$name.toggle");

    Route::get("/run/{task}", "SchedulerController@run")->name("$name.run");

    Route::get("/create", "SchedulerController@create")->name("$name.create");

    Route::post("/store", "SchedulerController@store")->name("$name.store");

    Route::delete("/delete", "SchedulerController@delete")->name("$name.delete");
});