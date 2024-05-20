<?php

namespace App\Models;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Row
{
    public int $moduleId;

    public function __construct(int $moduleId)
    {
        $this->moduleId = $moduleId;
    }

    public static function forModule(int $moduleId): self
    {
        return new self($moduleId);
    }

    public function paginate($perPage = 10): LengthAwarePaginator
    {
        $module = Module::with('primaryAttribute', 'attributes')->findOrFail($this->moduleId);
        $primaryValues = $this->getPrimaryValues($module->primaryAttribute->id, $perPage);
        $rows = $this->prepareRows($module, $primaryValues);

        return new LengthAwarePaginator(
            $rows,
            $primaryValues->total(),
            $primaryValues->perPage(),
            $primaryValues->currentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    public function get(): array
    {
        $module = Module::with('primaryAttribute', 'attributes')->findOrFail($this->moduleId);
        $primaryValues = $this->getPrimaryValues($module->primaryAttribute->id);
        return $this->prepareRows($module, $primaryValues);
    }

    public function find($primaryValueId)
    {
        $module = Module::with('attributes')->findOrFail($this->moduleId);
        $attributeValues = ModuleAttributeValue::where('primary_id', $primaryValueId)->get();
        return $this->prepareRow($module, $primaryValueId, $attributeValues);
    }

    private function getPrimaryValues($primaryAttributeId, $perPage = null)
    {
        $query = ModuleAttributeValue::where('module_attribute_id', $primaryAttributeId);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    private function prepareRows($module, $primaryValues)
    {
        $primaryValueIds = $primaryValues->pluck('id');
        $attributeValues = ModuleAttributeValue::whereIn('primary_id', $primaryValueIds)->get();

        $rows = [];
        foreach ($primaryValues as $primaryValue) {
            $rows[] = $this->prepareRow($module, $primaryValue->id, $attributeValues);
        }

        return $rows;
    }

    private function prepareRow(Module $module, int $primaryValueId, $attributeValues)
    {
        $row = [
            'primary' => $primaryValueId,
            'display_attribute_id' => $module->attributes[0]->id
        ];
        foreach ($module->attributes as $attribute) {
            $attributeValue = $attributeValues
                ->where('primary_id', $primaryValueId)
                ->where('module_attribute_id', $attribute->id)
                ->first();
            if ($attribute->type === ModuleAttribute::TYPE_REFERENCE) {
                $row[$attribute->id] = self::forModule($attribute->additional_info['reference_module_id'])->find($attributeValue?->value);
            } else {
                $row[$attribute->id] = $attributeValue?->value;
            }
        }
        return $row;
    }

    public function create(array $attributeValues)
    {
        $module = Module::with('primaryAttribute')->findOrFail($this->moduleId);

        DB::transaction(function () use ($attributeValues, $module) {
            $primaryValue = ModuleAttributeValue::create([
                'module_attribute_id' => $module->primaryAttribute->id,
                'value' => Str::uuid()
            ]);

            // Albarra: has the disadvantage that there is no validation that attribute_id has the correct value
            foreach ($attributeValues as $attr) {
                $value = $attr['value'];

                $typeAttribute = ModuleAttribute::where('id', $attr['attribute_id'])->value('type');
                if ($typeAttribute === ModuleAttribute::TYPE_REFERENCE) {
                    $value = $attr['value']['primary'];
                }

                ModuleAttributeValue::create([
                    'module_attribute_id' => $attr['attribute_id'],
                    'primary_id' => $primaryValue->id,
                    'value' => $value
                ]);
            }
        });
    }

    public function update($primaryValueId, array $attributeValues)
    {
        $primaryValue = ModuleAttributeValue::findOrFail($primaryValueId);

        DB::transaction(function () use ($attributeValues, $primaryValue) {
            // Albarra: has the disadvantage that there is no validation that attribute_id has the correct value
            foreach ($attributeValues as $attr) {
                $value = $attr['value'];

                $typeAttribute = ModuleAttribute::where('id', $attr['attribute_id'])->value('type');
                if ($typeAttribute === ModuleAttribute::TYPE_REFERENCE) {
                    $value = $attr['value']['primary'];
                }

                ModuleAttributeValue::updateOrCreate(
                    [
                        'module_attribute_id' => $attr['attribute_id'],
                        'primary_id' => $primaryValue->id
                    ],
                    [
                        'value' => $value
                    ]
                );
            }
        });
    }
}
