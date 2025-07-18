<?php

namespace App\Services;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;

class AttributeService
{
    public function create(StoreAttributeRequest $request)
    {
        try {
            $input = $request->except('_token', 'attribute_values');
            $input['is_color'] = (bool) $request->get('is_color', false);
            $input['status'] = (bool) $request->get('status', false);

            if (empty($input['slug'])) {
                $input['slug'] = generateSlug($input['name']);
            } else {
                $input['slug'] = generateSlug($input['slug']);
            }

            $baseSlug = $input['slug'];
            $i = 1;
            while (Attribute::where('slug', $input['slug'])->exists()) {
                $input['slug'] = $baseSlug . '-' . $i++;
            }

            $attribute = Attribute::create($input);

            if ($request->has('attribute_values')) {
                $attributeValues = json_decode($request->attribute_values, true);

                if (json_last_error() !== JSON_ERROR_NONE || !is_array($attributeValues)) {
                    return error('Invalid attribute values format');
                }

                foreach ($attributeValues as $value) {
                    $value['attribute_id'] = $attribute->id;
                    AttributeValue::create($value);
                }
            }

            return success('Attribute created successfully', $attribute);
        } catch (\Exception $e) {
            logError('Attribute Store Error: ' . $e->getMessage(), $e);

            return error('Failed to create attribute: ' . $e->getMessage());
        }
    }
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        try {
            $input = $request->except('_token', 'attribute_values');
            $input['is_color'] = (bool) $request->get('is_color', false);
            $input['status'] = (bool) $request->get('status', false);

            if (empty($input['slug'])) {
                $input['slug'] = generateSlug($input['name']);
            } else {
                $input['slug'] = generateSlug($input['slug']);
            }

            $baseSlug = $input['slug'];
            $i = 1;
            while (
                Attribute::where('slug', $input['slug'])
                ->where('id', '!=', $attribute->id)
                ->exists()
            ) {
                $input['slug'] = $baseSlug . '-' . $i++;
            }

            $attribute->update($input);

            if ($request->has('attribute_values')) {
                $attributeValues = json_decode($request->attribute_values, true);

                if (json_last_error() !== JSON_ERROR_NONE || !is_array($attributeValues)) {
                    return error('Invalid attribute values format');
                }

                $attribute->attributeValues()->delete();

                foreach ($attributeValues as $value) {
                    $value['attribute_id'] = $attribute->id;
                    AttributeValue::create($value);
                }
            }

            return success('Attribute updated successfully', $attribute);
        } catch (\Exception $e) {
            logError('Attribute Update Error: ' . $e->getMessage(), $e);
            return error('Failed to update attribute: ' . $e->getMessage());
        }
    }

    public function getList(Request $request)
    {
        $columns = [
            'id',
            'name',
            'slug',
            'status',
            // 'created_at',
            'actions',
        ];

        $searchables = [
            'name',
        ];

        return Attribute::datatable($request, $columns, [
            'searchables' => $searchables,
            'defaultOrderBy' => 'id',
            'defaultOrderDir' => 'desc',
            'with' => [],
            'modifyQuery' => fn($query) => $query,
            'formatRow' => function ($row, $model) {
                $row['status'] = $model->status ? "<span class='status-btn success-btn'>Active</span>" : "<span class='status-btn close-btn'>Inactive</span>";
                $row['created_at'] = $model->created_at->format('Y-m-d');
                $row['actions'] = "<div class='action-btns'>
                <a href='" . route('admin.attributes.edit', $model->id) . "' class='main-btn primary-btn btn-hover btn-sm'>
                    <i class='mdi mdi-pencil'></i>
                </a>
                <button type='button' class='main-btn danger-btn btn-hover btn-sm' onclick=deleteAttribute('{$model->id}',this.parentElement.parentElement)>
                    <i class='lni lni-trash-can'></i>
                </button>
            </div>";
                return $row;
            },
        ]);
    }
}
