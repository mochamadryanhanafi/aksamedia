<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/divisions', [DivisionController::class, 'index']);

    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
});

// SQL Bonus Endpoints (Placeholder for now)
Route::get('/nilaiRT', function() { return 'TODO'; });
Route::get('/nilaiST', function() { return 'TODO'; });
