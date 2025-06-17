<?php

namespace App\Services;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeService
{
    public function create(Request $request)
    {
        try {
            $attribute = new Attribute();
            $input = $request->except('_token', 'attribute_values');
            $input['status'] = (bool) $request->status;

            if (empty($input['slug'])) {
                $input['slug'] = generateSlug($input['name']);
            } else {
                $input['slug'] = generateSlug($input['slug']);
            }
            
            $baseSlug = $input['slug'];
            $i = 1;
            while (Attribute::where('slug', $input['slug'])->exists()) {
                $input['slug'] = $baseSlug . '-' . $i;
                $i++;
            }            

            $attribute->create($input);

            if ($request->has('attribute_values')) {
                $attributeValues = json_decode($request->attribute_values);

                foreach ($attributeValues as $attributeValue) {
                    $attributeValue->is_color = $attributeValue->color_code ? true : false;
                }

                $attributeValues = (array) $attributeValues;

                $attribute->attributeValues()->createMany($attributeValues);
            }

            return success('Attribute created successfully', $attribute);
        } catch (\Exception $e) {
            logError('Attribute Store Error ', $e);

            return error('Something went wrong');
        }    
    }
}
