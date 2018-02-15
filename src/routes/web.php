<?php

$url = config('scheduler.url');
$controller = 'MatviiB\\Scheduler\\Controllers\\SchedulerController';

Route::get($url, "$controller@index")->name("$url.index");

Route::get("$url/edit/{task}", "$controller@edit")->name("$url.edit");

Route::patch("$url/update/{task}", "$controller@update")->name("$url.update");

Route::get("$url/toggle/{task}", "$controller@toggle")->name("$url.toggle");

Route::get("$url/run/{task}", "$controller@run")->name("$url.run");

Route::get("$url/create", "$controller@create")->name("$url.create");

Route::post("$url/store", "$controller@store")->name("$url.store");

Route::delete("$url/delete", "$controller@delete")->name("$url.delete");
