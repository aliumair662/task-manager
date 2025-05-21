<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

Route::get('/', [TaskController::class, 'index']);
Route::resource('tasks', TaskController::class)->except(['show', 'create']);
Route::post('/tasks/reorder', [TaskController::class, 'reorder']);
Route::resource('projects', ProjectController::class)->only(['index']);