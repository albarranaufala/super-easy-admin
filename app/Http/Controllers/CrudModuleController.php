<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CrudModuleController extends Controller
{
    public function index(int $moduleId)
    {
        $module = Module::with('primaryAttribute', 'attributes')->findOrFail($moduleId);
        $primaryAttribute = $module->primaryAttribute;
        $primaryValues = ModuleAttributeValue::where('module_attribute_id', $primaryAttribute->id)
            ->paginate(5);
        $primaryValueIds = $primaryValues->pluck('id');
        $attributeValues = ModuleAttributeValue::whereIn('primary_id', $primaryValueIds)->get();

        $rows = [];
        foreach ($primaryValues as $primaryValue) {
            $row = [
                'primary' => $primaryValue
            ];
            foreach ($module->attributes as $attribute) {
                $attributeValue = $attributeValues
                    ->where('primary_id', $primaryValue->id)
                    ->where('module_attribute_id', $attribute->id)
                    ->first();

                $row[$attribute->id] = $attributeValue->value;
            }
            $rows[] = $row;
        }

        $rows = new LengthAwarePaginator(
            $rows,
            $primaryValues->total(),
            $primaryValues->perPage(),
            $primaryValues->currentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        return Inertia::render('Crud/Index', compact('module', 'rows'));
    }

    public function create(int $moduleId)
    {
        $module = Module::with('attributes')->findOrFail($moduleId);

        return Inertia::render('Crud/Create', compact('module'));
    }

    public function store(int $moduleId, Request $request)
    {
        $request->validate([
            'row' => 'required|array',
            'row.*.attribute_id' => 'required|integer',
            'row.*.value' => 'required'
        ]);

        $module = Module::with('primaryAttribute')->findOrFail($moduleId);

        $primaryValue = ModuleAttributeValue::create([
            'module_attribute_id' => $module->primaryAttribute->id,
            'value' => Str::uuid()
        ]);

        // Albarra: has the disadvantage that there is no validation that attribute_id has the correct value
        foreach ($request->input('row') as $attr) {
            ModuleAttributeValue::create([
                'module_attribute_id' => $attr['attribute_id'],
                'primary_id' => $primaryValue->id,
                'value' => $attr['value']
            ]);
        }

        return to_route('crud.modules.index', $moduleId);
    }


    public function edit(int $moduleId, int $primaryValueId)
    {
        $module = Module::with('attributes')->findOrFail($moduleId);
        $attributeValues = ModuleAttributeValue::where('primary_id', $primaryValueId)->get();
        $row = [
            'primary' => $primaryValueId
        ];
        foreach ($module->attributes as $attribute) {
            $attributeValue = $attributeValues
                ->where('primary_id', $primaryValueId)
                ->where('module_attribute_id', $attribute->id)
                ->first();

            $row[$attribute->id] = $attributeValue->value;
        }

        return Inertia::render('Crud/Edit', compact('module', 'row'));
    }

    public function update(int $moduleId, int $primaryValueId, Request $request)
    {
        $request->validate([
            'row' => 'required|array',
            'row.*.attribute_id' => 'required|integer',
            'row.*.value' => 'required'
        ]);

        $primaryValue = ModuleAttributeValue::findOrFail($primaryValueId);

        // Albarra: has the disadvantage that there is no validation that attribute_id has the correct value
        foreach ($request->input('row') as $attr) {
            ModuleAttributeValue::where('module_attribute_id', $attr['attribute_id'])
                ->where('primary_id', $primaryValue->id)
                ->update([
                    'value' => $attr['value']
                ]);
        }

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
