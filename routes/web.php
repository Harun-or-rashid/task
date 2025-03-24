<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TeamController;

Route::get('/', function () {
    return view ('admin.index');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function() {
    Route::get('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('login', [AuthController::class, 'submitLogin'])->name('login.submit');

    Route::middleware(['auth:admin'])->group(function() {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout.submit');
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        //organization crud
        Route::get('/list', [OrganizationController::class, 'index'])->name('list.organization');
        Route::get('/create', [OrganizationController::class, 'create'])->name('create.organization');
        Route::post('/store', [OrganizationController::class, 'store'])->name('store.organization');
        Route::get('/edit/{id}', [OrganizationController::class, 'edit'])->name('edit.organization');
        Route::post('/update/{id}', [OrganizationController::class, 'update'])->name('update.organization');
        Route::delete('/delete/{id}', [OrganizationController::class, 'delete'])->name('delete.organization');
        //team crud
        Route::get('/team-list', [TeamController::class, 'index'])->name('list.team');
        Route::get('/team-create', [TeamController::class, 'create'])->name('create.team');
        Route::post('/team-store', [TeamController::class, 'store'])->name('store.team');
        Route::get('/team-edit/{id}', [TeamController::class, 'edit'])->name('edit.team');
        Route::post('/team-update/{id}', [TeamController::class, 'update'])->name('update.team');
        Route::delete('/team-delete/{id}', [TeamController::class, 'delete'])->name('delete.team');
        Route::get('/get-teams/{organization_id}', [TeamController::class, 'getTeams']);
        //employee crud
        Route::get('/employee-create', [EmployeeController::class, 'create'])->name('create.employee');
        Route::get('/employee-list', [EmployeeController::class, 'index'])->name('list.employee');
        Route::post('/employee-store', [EmployeeController::class, 'store'])->name('store.employee');
        Route::get('/employee-edit/{id}', [EmployeeController::class, 'edit'])->name('edit.employee');
        Route::post('/employee-update/{id}', [EmployeeController::class, 'update'])->name('update.employee');
        Route::delete('/employee-delete/{id}', [EmployeeController::class, 'delete'])->name('delete.employee');
        //report
        Route::get('/teams/average-salary', [ReportController::class, 'teamSalaryReport'])->name('teams.average.salary');
        Route::get('/organizations/employee-count', [ReportController::class, 'organizationEmployeeCount'])->name('organizations.employee.count');

    });
});
