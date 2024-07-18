<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
  return ['Laravel' => app()->version()];
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('/dashboard', [DashboardController::class, 'store']);
Route::delete('/dashboard/{id}', [DashboardController::class, 'destroy']);
Route::put('/dashboard/{id}', [DashboardController::class, 'update']);

require __DIR__ . '/auth.php';
