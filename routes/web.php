<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UpdateController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $users = User::all();
        return view('dashboard',compact('users'));

    })->name('dashboard');
});


//Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('AllCat');
Route::post('/categories', [CategoryController::class, 'store'])->name('AllCat');

Route::get('/categories/{id}/update', [UpdateController::class, 'showUpdateForm'])->name('update.page');
Route::put('/categories/{id}/update', [UpdateController::class, 'update'])->name('update.category');

Route::get('/categories/{id}/soft-delete', [CategoryController::class, 'softDelete'])->name('softDelete.category');

Route::put('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('restore.category');
Route::delete('/categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('forceDelete.category');

