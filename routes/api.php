<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermissions;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\OrganizationController;


Route::post('/admin-login', [AdminAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AdminAuthController::class, 'logout']);

Route::prefix('v1')->middleware([ CheckPermissions::class])->group(function () {
    // Resource Controllers
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('teams', TeamController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::get('/create-maneger', [EmployeeController::class, 'manegerCreate'])->name('maneger.create');
    Route::post('/store-maneger', [EmployeeController::class, 'manegerStore'])->name('manegerstore');
    Route::get('/list-maneger', [EmployeeController::class, 'manegerList'])->name('maneger.list');
    Route::get('/edit-maneger/{id}', [EmployeeController::class, 'manegerEdit'])->name('maneger.edit');
    Route::post('/update-maneger/{id}', [EmployeeController::class, 'manegerUpdate'])->name('maneger.update');
    Route::delete('/delete-maneger/{id}', [EmployeeController::class, 'manegerDelete'])->name('maneger.delete');

    // Additional Endpoints
    Route::get('teams/organization/{organization_id}', [TeamController::class, 'getTeamsByOrganization']);
    Route::get('organization/{organization_id}', [EmployeeController::class, 'getEmployeesByOrganization']);
    Route::get('team/{team_id}', [EmployeeController::class, 'getEmployeesByTeam']);

    // Reports
    Route::get('/teams/average/salary', [ReportController::class, 'teamSalaryReport']);
    Route::get('/organizations/employee/count', [ReportController::class, 'organizationEmployeeCount']);
});


