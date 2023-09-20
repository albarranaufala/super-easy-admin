<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')
            ->orderBy('name')
            ->paginate();

        return Inertia::render('Users/Index', compact('users'));
    }

    public function create(Request $request)
    {
        $roles = Role::query()
            ->when($request->input('search_role'), function (Builder $query, $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orderBy('name')
            ->limit(5)
            ->get();

        return Inertia::render('Users/Create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id')
        ]);

        event(new Registered($user));

        return to_route('users.index');
    }
}
