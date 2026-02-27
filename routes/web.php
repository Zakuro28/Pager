<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ui-kit', function () {
    return view('ui-kit');
})->name('ui-kit');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
