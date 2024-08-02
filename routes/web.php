<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return ['Laravel' => app()->version()];
});

Route::get('/{any}', function () {
  return view('app');
})->where('any', '.*');

require __DIR__ . '/auth.php';
