<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate();

        return Inertia::render('Users/Index', compact('users'));
    }
}
