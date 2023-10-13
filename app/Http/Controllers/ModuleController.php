<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Str;

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
            'attributes.*.type' => ['required', 'string', Rule::in('text', 'switch', 'select')],
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.options' => 'nullable|array',
            'attributes.*.options.*.name' => 'required|string'
        ]);

        DB::transaction(function () use ($request) {
            $module = Module::create([
                'name' => $request->input('name')
            ]);
            ModuleAttribute::create([
                'module_id' => $module->id,
                'type' => 'primary',
                'name' => 'ID'
            ]);
            foreach ($request->input('attributes') as $attrReq) {
                $moduleAttribute = new ModuleAttribute();
                $moduleAttribute->module_id = $module->id;
                $moduleAttribute->type = $attrReq['type'];
                $moduleAttribute->name = $attrReq['name'];
                $options = [];
                if ($attrReq['type'] === 'select') {
                    foreach ($attrReq['options'] as $option) {
                        $options[] = [
                            'id' => Str::uuid(),
                            'name' => $option['name']
                        ];
                    }
                    $moduleAttribute->additional_info = [
                        'options' => $options
                    ];
                }
                $moduleAttribute->save();
            }
        });

        return to_route('modules.index');
    }
}
