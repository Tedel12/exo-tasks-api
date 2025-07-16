<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TaskController;


// Routes API pour l'application
// Elles sont regroupées par version et utilisent des contrôleurs pour gérer les requêtes
Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');                                                        
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/user', [AuthController::class, 'user']);
    });

    // Routes des équipes (accessible à tous)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/teams', [TeamController::class, 'index']);
        Route::get('/teams/{id}', [TeamController::class, 'show']);
        Route::post('/teams', [TeamController::class, 'store']);
        Route::put('/teams/{id}', [TeamController::class, 'update']);
        Route::delete('/teams/{id}', [TeamController::class, 'destroy']);
    });

    // Routes des users (accessible à tous)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });

    
    // Routes des tâches (avec gestion des rôles, il faut être manager pour créer, mettre à jour ou supprimer une tâche)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/tasks', [TaskController::class, 'index']);
        Route::get('/tasks/{id}', [TaskController::class, 'show']);
        Route::middleware(['CheckManager:manager'])->group(function () {
            Route::post('/tasks', [TaskController::class, 'store']);
            Route::put('/tasks/{id}', [TaskController::class, 'update']);
            Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
        });
    });
});

// Middleware pour vérifier si l'utilisateur a le rôle de manager
Route::aliasMiddleware('role', \App\Http\Middleware\CheckManager::class);