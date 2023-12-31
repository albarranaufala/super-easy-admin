<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleAttribute;
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
        $module = Module::findOrFail($moduleId);
        $attributes = ModuleAttribute::where('module_id', $module->id)
            ->get();
        $primaryAttribute = $attributes->where('type', 'primary')->first();
        $primaryValues = ModuleAttributeValue::where('module_attribute_id', $primaryAttribute->id)
            ->paginate(5);
        $primaryValueIds = $primaryValues->pluck('id');
        $attributeValues = ModuleAttributeValue::whereIn('id', $primaryValueIds)->orWhereIn('primary_id', $primaryValueIds)->get();

        $rows = [];
        foreach ($primaryValues as $primaryValue) {
            $row = [];
            foreach ($attributes as $attribute) {
                $attributeValue = $attributeValues
                    ->filter(function ($value) use ($primaryValue, $attribute) {
                        return ($value->id === $primaryValue->id && $value->module_attribute_id === $attribute->id) || ($value->primary_id === $primaryValue->id && $value->module_attribute_id === $attribute->id);
                    })
                    ->first();

                if ($attribute->type === 'primary') {
                    $row['primary'] = $attributeValue->id;
                } else {
                    $row[$attribute->id] = $attributeValue->value;
                }
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

        return Inertia::render('Crud/Index', compact('module', 'attributes', 'rows'));
    }

    public function create(int $moduleId)
    {
        $module = Module::findOrFail($moduleId);
        $attributes = ModuleAttribute::where('module_id', $module->id)
            ->whereNot('type', 'primary')
            ->get();

        return Inertia::render('Crud/Create', compact('module', 'attributes'));
    }

    public function store(int $moduleId, Request $request)
    {
        $request->validate([
            'row' => 'required|array',
            'row.*.attribute_id' => 'required|integer',
            'row.*.value' => 'required'
        ]);

        $primaryAttributeId = ModuleAttribute::where('module_id', $moduleId)
            ->where('type', 'primary')
            ->value('id');

        $primaryValue = ModuleAttributeValue::create([
            'module_attribute_id' => $primaryAttributeId,
            'value' => Str::uuid()
        ]);

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
        $module = Module::findOrFail($moduleId);
        $attributes = ModuleAttribute::where('module_id', $module->id)
            ->get();
        $attributeValues = ModuleAttributeValue::where('id', $primaryValueId)->orWhere('primary_id', $primaryValueId)->get();
        $row = [];
        foreach ($attributes as $attribute) {
            $attributeValue = $attributeValues
                ->filter(function ($value) use ($primaryValueId, $attribute) {
                    return ($value->id === $primaryValueId && $value->module_attribute_id === $attribute->id) || ($value->primary_id === $primaryValueId && $value->module_attribute_id === $attribute->id);
                })
                ->first();

            if ($attribute->type === 'primary') {
                $row['primary'] = $attributeValue->id;
            } else {
                $row[$attribute->id] = $attributeValue->value;
            }
        }

        return Inertia::render('Crud/Edit', compact('module', 'attributes', 'row'));
    }

    public function update(int $moduleId, int $primaryValueId, Request $request)
    {
        $request->validate([
            'row' => 'required|array',
            'row.*.attribute_id' => 'required|integer',
            'row.*.value' => 'required'
        ]);

        $primaryValue = ModuleAttributeValue::findOrFail($primaryValueId);

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
