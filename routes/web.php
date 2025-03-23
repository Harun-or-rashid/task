<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('admin.index');
});

Route::get('/login', function () {
    return view('admin.auth.login');
});

// Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/organizations', [DashboardController::class, 'organizations'])->name('organizations');
Route::get('/organizations-list', [DashboardController::class, 'organizationList'])->name('organization.list');
// Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function() {
    Route::get('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('login', [AuthController::class, 'submitLogin'])->name('login.submit');

    Route::middleware(['auth:admin'])->group(function() {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout.submit');
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    });
});
