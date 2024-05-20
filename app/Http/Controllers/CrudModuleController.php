<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleAttributeValue;
use App\Models\Row;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CrudModuleController extends Controller
{
    public function index(int $moduleId)
    {
        $module = Module::with('attributes')->findOrFail($moduleId);
        $rows = Row::forModule($moduleId)->paginate(5);

        return Inertia::render('Crud/Index', compact('module', 'rows'));
    }

    public function create(int $moduleId)
    {
        $module = Module::with('attributes')->findOrFail($moduleId);
        $module->attributes->each->append('referenced_module_rows');
        return Inertia::render('Crud/Create', compact('module'));
    }

    public function store(int $moduleId, Request $request)
    {
        $request->validate([
            'attribute_values' => 'required|array',
            'attribute_values.*.attribute_id' => 'required|integer',
            'attribute_values.*.value' => 'required'
        ]);

        Row::forModule($moduleId)->create($request->input('attribute_values'));

        return to_route('crud.modules.index', $moduleId);
    }


    public function edit(int $moduleId, int $primaryValueId)
    {
        $module = Module::with('attributes')->findOrFail($moduleId);
        $module->attributes->each->append('referenced_module_rows');
        $row = Row::forModule($module->id)->find($primaryValueId);

        return Inertia::render('Crud/Edit', compact('module', 'row'));
    }

    public function update(int $moduleId, int $primaryValueId, Request $request)
    {
        $request->validate([
            'attribute_values' => 'required|array',
            'attribute_values.*.attribute_id' => 'required|integer',
            'attribute_values.*.value' => 'required'
        ]);

        Row::forModule($moduleId)->update($primaryValueId, $request->input('attribute_values'));

        return to_route('crud.modules.index', $moduleId);
    }

    public function destroy(int $moduleId, int $primaryValueId)
    {
        $primaryValue = ModuleAttributeValue::findOrFail($primaryValueId);

        ModuleAttributeValue::where('primary_id', $primaryValue->id)
            ->delete();

        $primaryValue->delete();

        return to_route('crud.modules.index', $moduleId);
    }
}
