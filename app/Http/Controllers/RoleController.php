<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->paginate();

        return Inertia::render('Roles/Index', compact('roles'));
    }

    public function create()
    {
        $modules = Module::with('attributes')->get();

        return Inertia::render('Roles/Create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*.module_id' => 'required|integer',
            'permissions.*.actions' => 'required|array',
            'permissions.*.actions.*' => 'required|array',
            'permissions.*.actions.*.action' => ['required', Rule::in(Permission::AVAILABLE_ACTIONS)],
            'permissions.*.actions.*.query' => ['required']
        ]);

        DB::transaction(function () use ($request) {
            $role = Role::create([
                'name' => $request->input('name')
            ]);
            foreach ($request->input('permissions') as $permissionReq) {
                foreach ($permissionReq['actions'] as $action) {
                    $role->permissions()->create([
                        'module_id' => $permissionReq['module_id'],
                        'action' => $action['action'],
                        'query' => $action['query']
                    ]);
                }
            }
        });

        return to_route('roles.index');
    }

    public function edit(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $modules = Module::with('attributes')->get();

        return Inertia::render('Roles/Edit', compact('role', 'modules'));
    }

    public function update(int $id, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*.module_id' => 'required|integer',
            'permissions.*.actions' => 'required|array',
            'permissions.*.actions.*' => 'required|array',
            'permissions.*.actions.*.action' => ['required', Rule::in(Permission::AVAILABLE_ACTIONS)],
            'permissions.*.actions.*.query' => ['required']
        ]);

        $role = Role::findOrFail($id);

        DB::transaction(function () use ($request, $role) {
            $role->update([
                'name' => $request->input('name')
            ]);
            foreach ($request->input('permissions') as $permissionReq) {
                foreach ($permissionReq['actions'] as $action) {
                    $role->permissions()->updateOrCreate([
                        'module_id' => $permissionReq['module_id'],
                        'action' => $action['action'],
                    ], [
                        'query' => $action['query']
                    ]);
                }
            }
        });

        return to_route('roles.index');
    }

    public function destroy(int $id, Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $role = Role::findOrFail($id);
        $role->delete();

        return to_route('roles.index');
    }
}
