<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Auth;


class RoleController extends Controller
{
    private $routeLists;
    public $role;

    public function index()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            $middlewares = $route->middleware();
            return in_array('auth:sanctum', $middlewares) && !in_array('api', $middlewares);
        })->reject(function ($route) {
            return $route->getName() === 'dashboard';
        })->groupBy(function ($route) {
            $uri = $route->uri();
            $segments = explode('/', $uri);
            return $segments[0]; // Assuming the prefix is always the first segment
        })->map(function ($routes) {
            return $routes->reject(function ($route) {
                return $route->getName() === 'profile.show';
            })->map(function ($route) {
                return $route->getName();
            });
        });
//        dd($routes);
        return view('role.index', ['routeLists' => $routes]);
    }

    public function create(Request $request)
    {
        $this->role = Role::newRole($request);
        RoleRoute::newRoleRoute($request, $this->role);
        return redirect('/role/add')->with('message', 'Role info create successfully.');
    }

    public function manage(Request $request)
    {
        $user = Auth::user();
        $routeName = $request->route()->getName();
        $routesData = RoleRoute::where('route_name', $routeName)->get();
        $roles = $routesData->pluck('role_name')->toArray();
        $userRoles = $user->roles->pluck('name')->toArray();
        if (count(array_intersect($userRoles, $roles)) > 0) {
            return response()->json('OK');
        }

//        dd($roles);
        return view('role.manage', ['roles' => Role::all()]);
    }

    public function edit($id)
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            $middlewares = $route->middleware();
            return in_array('auth:sanctum', $middlewares) && !in_array('api', $middlewares);
        })->reject(function ($route) {
            return $route->getName() === 'dashboard';
        })->groupBy(function ($route) {
            $uri = $route->uri();
            $segments = explode('/', $uri);
            return $segments[0]; // Assuming the prefix is always the first segment
        })->map(function ($routes) {
            return $routes->reject(function ($route) {
                return $route->getName() === 'profile.show';
            })->map(function ($route) {
                return $route->getName();
            });
        });
        return view('role.edit', ['role' => Role::find($id), 'routeLists' => $routes]);
    }

    public function update(Request $request, $id)
    {
        $this->role = Role::updateRole($request, $id);
        RoleRoute::updateRoleRoute($request, $this->role);
        return redirect('/role/manage')->with('message', 'Role info update successfully.');
    }

    public function delete($id)
    {
        Role::deleteRole($id);
        RoleRoute::deleteRoleRoute($id);
        return redirect('/role/manage')->with('message', 'Role info delete successfully.');
    }
}
