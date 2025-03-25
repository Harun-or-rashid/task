<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $user = Auth::guard('admin')->user();

       if ($user) {
           $permissions = [
               'manage_organization' => $user->manage_organization,
               'manage_team' => $user->manage_team,
               'manage_employee' => $user->manage_employee,
               'manage_report' => $user->manage_report,
               'manage_maneger' => $user->manage_maneger,
           ];
           $request->merge(['permissions' => $permissions]);

           // If the user is an Admin, allow access to all routes
           if ($user->role === 'Admin') {
               return $next($request);
           }

           // If the user's role is Manager, check specific permissions for routes
           if ($user->role === 'Manager') {
               // Get the route name to check permissions for specific actions
               $routeName = $request->route()->getName();

               // Restrict access to certain routes based on permissions
               if (in_array($routeName, ['list.organization', 'create.organization', 'store.organization', 'edit.organization', 'update.organization', 'delete.organization']) && !$permissions['manage_organization']) {
                   return redirect()->back()->with('error', 'You do not have permission to manage organizations.');
               }

               if (in_array($routeName, ['list.team', 'create.team', 'store.team', 'edit.team', 'update.team', 'delete.team']) && !$permissions['manage_team']) {
                   return redirect()->back()->with('error', 'You do not have permission to manage teams.');
               }

               if (in_array($routeName, ['list.employee', 'create.employee', 'store.employee', 'edit.employee', 'update.employee', 'delete.employee']) && !$permissions['manage_employee']) {
                   return redirect()->back()->with('error', 'You do not have permission to manage employees.');
               }

               if (in_array($routeName, ['teams.average.salary', 'organizations.employee.count']) && !$permissions['manage_report']) {
                   return redirect()->back()->with('error', 'You do not have permission to view reports.');
               }
               if (in_array($routeName, ['organizations.index', 'organizations.create']) && !$permissions['manage_report']) {
                   return redirect()->back()->with('error', 'You do not have permission to view reports.');
               }
               if (in_array($routeName, ['maneger.list', 'maneger.create', 'maneger.store', 'maneger.edit', 'maneger.update', 'maneger.delete']) && !$permissions['manage_maneger']) {
                return redirect()->back()->with('error', 'You do not have permission to manage managers.');
                }
               if (in_array($routeName, ['list.maneger', 'create.maneger', 'store.maneger', 'edit.maneger', 'update.maneger', 'delete.maneger']) && !$permissions['manage_maneger']) {
                return redirect()->back()->with('error', 'You do not have permission to manage managers.');
                }

               $restrictedRoutes = [
                // Organization routes
                'organizations.index' => 'manage_organization',
                'organizations.store' => 'manage_organization',
                'organizations.show' => 'manage_organization',
                'organizations.update' => 'manage_organization',
                'organizations.destroy' => 'manage_organization',

                // Team routes
                'teams.index' => 'manage_team',
                'teams.store' => 'manage_team',
                'teams.show' => 'manage_team',
                'teams.update' => 'manage_team',
                'teams.destroy' => 'manage_team',

                // Employee routes
                'employees.index' => 'manage_employee',
                'employees.store' => 'manage_employee',
                'employees.show' => 'manage_employee',
                'employees.update' => 'manage_employee',
                'employees.destroy' => 'manage_employee',

                // Report routes
                'teams.average.salary' => 'manage_report',
                'organizations.employee.count' => 'manage_report',
            ];

            // Restrict access if permission is not granted
            if (isset($restrictedRoutes[$routeName]) && !$permissions[$restrictedRoutes[$routeName]]) {
                return response()->json([
                    'error' => 'You do not have permission to access this resource.'
                ], 403);
            }
           }
       }

       // If all checks pass, proceed with the request
       return $next($request);
    }
}
