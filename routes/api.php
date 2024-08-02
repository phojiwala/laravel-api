<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::middleware('auth:sanctum')->prefix('dashboard')->group(function () {
  Route::get('/', [DashboardController::class, 'index']);
  Route::post('/', [DashboardController::class, 'store']);
  Route::get('/{id}', [DashboardController::class, 'show']);
  Route::put('/{id}', [DashboardController::class, 'update']);
  Route::delete('/{id}', [DashboardController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/accounts', [AccountController::class, 'index']);
