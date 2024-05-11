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
        $modules = Module::all();
        $availableTypes = Module::AVAILABLE_TYPES;

        return Inertia::render('Modules/Create', compact('modules', 'availableTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'attributes' => 'required|array|min:1',
            'attributes.*.type' => ['required', 'string', Rule::in(Module::AVAILABLE_TYPES)],
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.options' => 'nullable|array',
            'attributes.*.options.*.name' => 'required|string',
            'attributes.*.reference_module_id' => 'nullable|integer'
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
                if ($attrReq['type'] === Module::TYPE_SELECT) {
                    foreach ($attrReq['options'] as $option) {
                        $options[] = [
                            'id' => Str::uuid(),
                            'name' => $option['name']
                        ];
                    }
                    $moduleAttribute->additional_info = [
                        'options' => $options
                    ];
                } elseif ($attrReq['type'] === Module::TYPE_REFERENCE) {
                    $moduleAttribute->additional_info = [
                        'reference_module_id' => $attrReq['reference_module_id']
                    ];
                }
                $moduleAttribute->save();
            }
        });

        return to_route('modules.index');
    }

    public function edit(int $moduleId)
    {
        $module = Module::with('attributes')
            ->findOrFail($moduleId);
        $modules = Module::whereNot('id', $module->id)->get();
        $availableTypes = Module::AVAILABLE_TYPES;

        return Inertia::render('Modules/Edit', compact('module', 'modules', 'availableTypes'));
    }

    public function update(int $moduleId, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'attributes' => 'required|array|min:1',
            'attributes.*.id' => 'nullable|integer',
            'attributes.*.type' => ['required', 'string', Rule::in(Module::AVAILABLE_TYPES)],
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.options' => 'nullable|array',
            'attributes.*.options.*.name' => 'required|string',
            'attributes.*.reference_module_id' => 'nullable|integer'
        ]);

        $module = Module::with('attributes')->findOrFail($moduleId);

        DB::transaction(function () use ($request, $module) {
            $module->update(['name' => $request->input('name')]);

            $attrsReq = collect($request->input('attributes'));

            // Delete attributes that are no longer used
            $module->attributes()
                ->whereNotIn('id', $attrsReq->pluck('id'))
                ->delete();

            // Add or update attributes
            foreach ($attrsReq as $attrReq) {
                $moduleAttribute = $module->attributes->find($attrReq['id']);
                if (!$moduleAttribute) {
                    $moduleAttribute = new ModuleAttribute();
                    $moduleAttribute->module_id = $module->id;
                }
                $moduleAttribute->type = $attrReq['type'];
                $moduleAttribute->name = $attrReq['name'];
                if ($attrReq['type'] === Module::TYPE_SELECT) {
                    $options = [];
                    foreach ($attrReq['options'] as $option) {
                        $options[] = [
                            'id' => Str::uuid(),
                            'name' => $option['name']
                        ];
                    }
                    $moduleAttribute->additional_info = [
                        'options' => $options
                    ];
                } elseif ($attrReq['type'] === Module::TYPE_REFERENCE) {
                    $moduleAttribute->additional_info = [
                        'reference_module_id' => $attrReq['reference_module_id']
                    ];
                }
                $moduleAttribute->save();
            }
        });

        return to_route('modules.edit', $module->id);
    }

    public function destroy(int $moduleId, Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $module = Module::findOrFail($moduleId);
        $module->delete();

        return to_route('modules.index');
    }
}
