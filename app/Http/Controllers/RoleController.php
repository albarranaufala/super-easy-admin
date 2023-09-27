<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;
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
        $modules = Module::with('fillableAttributes')->get();

        return Inertia::render('Roles/Create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        Role::create([
            'name' => $request->input('name')
        ]);

        return to_route('roles.index');
    }
}
