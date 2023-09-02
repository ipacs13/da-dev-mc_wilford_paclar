<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TodoController;

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

Route::group(['prefix' => 'todos', 'as' => 'todos.', 'namespace' => 'API'], static function (): void {
    Route::get('/', [TodoController::class, 'index'])->name('index');
    Route::post('/', [TodoController::class, 'store'])->name('store');
    Route::put('/{id}', [TodoController::class, 'update'])->name('update');
    Route::delete('/{id}', [TodoController::class, 'deleteItem'])->name('destroy');
});
