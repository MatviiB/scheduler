<?php

$url = config('scheduler.url');
$controller = 'MatviiB\\Scheduler\\Controllers\\SchedulerController';

const CONTROLLER = 'MatviiB\\Scheduler\\Controllers\\SchedulerController';

Route::get($url, "$controller@index")->name("$url.index");

Route::get("$url/toggle/{task}", "$controller@toggle")->name("$url.toggle");

Route::get("$url/run/{task}", "$controller@run")->name("$url.run");

