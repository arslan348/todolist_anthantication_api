<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register',[Apis::class,'register']); 

Route::post('/login',[Apis::class,'login']);

Route::get('/login',[Apis::class,'login'])->name('login');

Route::middleware('auth:api')->get('todos', [TodoController::class, 'index']);
Route::middleware('auth:api')->post('store-todo', [TodoController::class, 'store']);
// Route::get('todos', [TodoController::class, 'index']);
// Route::post('store-todo', [TodoController::class, 'store']);
// Route::get('store-todo', [TodoController::class, 'store']);
Route::post('delete-todo', [TodoController::class, 'delete']);
Route::post('todo/mark-as-done', [TodoController::class, 'markAsDone']);
Route::post('todo/mark-as-undone', [TodoController::class, 'markAsUnDone']);
