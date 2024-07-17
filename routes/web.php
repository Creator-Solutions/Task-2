<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/api/tasks', [TaskController::class, 'index'])->name('api/tasks');
Route::post('/tasks/store', [TaskController::class, 'store']);
Route::delete('/tasks/{id}', [TaskController::class, 'delete']);
Route::put('/tasks/{id}', [TaskController::class, 'edit']);

Route::get('/tasks/token', [TaskController::class, 'token']);
Route::get('/', function () {
    return view('welcome');
});
