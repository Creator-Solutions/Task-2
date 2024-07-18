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
Route::post('/api/tasks/store', [TaskController::class, 'store'])->name('api/tasks/store');
Route::delete('/api/tasks/{id}', [TaskController::class, 'delete'])->name('api/tasks/{id}');
Route::put('/api/tasks/{id}', [TaskController::class, 'edit'])->name('api/tasks/{id}');

Route::get('/tasks/token', [TaskController::class, 'token']);
Route::get('/', function () {
    return view('welcome');
});
