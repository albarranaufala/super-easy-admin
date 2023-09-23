<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('attributes')->paginate();

        return Inertia::render('Modules/Index', compact('modules'));
    }

    public function create()
    {
        return Inertia::render('Modules/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'attributes' => 'required|array|min:1',
            'attributes.*.type' => 'required|string',
            'attributes.*.name' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request) {
            $module = Module::create([
                'name' => $request->input('name')
            ]);
            ModuleAttribute::create([
                'module_id' => $module->id,
                'type' => 'primary',
                'name' => 'id'
            ]);
            foreach ($request->input('attributes') as $attrReq) {
                ModuleAttribute::create([
                    'module_id' => $module->id,
                    'type' => $attrReq['type'],
                    'name' => $attrReq['name']
                ]);
            }
        });

        return to_route('modules.index');
    }
}
