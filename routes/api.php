<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
  return $request->user();
});

Route::middleware(['auth:sanctum'])->get('/dashboard', [DashboardController::class, 'index']);
Route::middleware(['auth:sanctum'])->post('/dashboard', [DashboardController::class, 'index']);
Route::middleware(['auth:sanctum'])->put('/dashboard', [DashboardController::class, 'index']);
