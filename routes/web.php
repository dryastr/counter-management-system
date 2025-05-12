<?php

use App\Http\Controllers\admin\AddUsersController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ProductsController;
use App\Http\Controllers\admin\TypesProductsController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
    return redirect()->route('login');
})->name('home');

Auth::routes(['middleware' => ['redirectIfAuthenticated']]);


Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('type-products', TypesProductsController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('add-users', AddUsersController::class);
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');
});
