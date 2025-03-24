<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\OrganizationController;


Route::post('/login', [AdminAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AdminAuthController::class, 'logout']);

Route::prefix('v1')->group(function () {
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('teams', TeamController::class);
    Route::get('teams/organization/{organization_id}', [TeamController::class, 'getTeamsByOrganization']);
    Route::apiResource('employees', EmployeeController::class);
    Route::get('organization/{organization_id}', [EmployeeController::class, 'getEmployeesByOrganization']);
    Route::get('team/{team_id}', [EmployeeController::class, 'getEmployeesByTeam']);
    Route::get('/teams/average/salary', [ReportController::class, 'teamSalaryReport']);
    Route::get('/organizations/employee/count', [ReportController::class, 'organizationEmployeeCount']);
});


