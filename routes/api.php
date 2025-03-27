<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermissions;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\EmployeeDashboardController;


Route::post('/admin-login', [AdminAuthController::class, 'login']);
// Route::post('/user-login', [AdminAuthController::class, 'userLogin']);
Route::middleware('auth:sanctum')->post('/logout', [AdminAuthController::class, 'logout']);
// Route::middleware('auth:sanctum')->get('/employee-dashboard', [EmployeeDashboardController::class, 'index']);

Route::prefix('v1')->middleware(['auth:sanctum',CheckPermissions::class])->group(function () {
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
    Route::get('/import', [EmployeeController::class, 'showImportForm'])->name('import.employee.form');
    Route::post('/import', [EmployeeController::class, 'importEmployees'])->name('import.employee');

    // Additional Endpoints
    Route::get('teams/organization/{organization_id}', [TeamController::class, 'getTeamsByOrganization']);
    Route::get('organization/{organization_id}', [EmployeeController::class, 'getEmployeesByOrganization']);
    Route::get('team/{team_id}', [EmployeeController::class, 'getEmployeesByTeam']);

    // Reports
    Route::get('/teams/average/salary', [ReportController::class, 'teamSalaryReport']);
    Route::get('/organizations/employee/count', [ReportController::class, 'organizationEmployeeCount']);
    Route::get('/employee-report/{id}', [ReportController::class, 'generatePDF'])->name('employee.report.pdf');
    Route::get('/teams/average-salary/pdf/{id}', [ReportController::class, 'teamSalaryReportpdf'])->name('teams.average.salary.pdf');
});


