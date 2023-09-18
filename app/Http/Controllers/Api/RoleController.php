<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        return Role::where('name', 'like', '%' . $search . '%')
            ->paginate();
    }
}
