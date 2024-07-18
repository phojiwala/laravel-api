<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index']);
  Route::post('/dashboard', [DashboardController::class, 'store']);
  Route::delete('/dashboard/{id}', [DashboardController::class, 'destroy']);
  Route::put('/dashboard/{id}', [DashboardController::class, 'update']);
});
