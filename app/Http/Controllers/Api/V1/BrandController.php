<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;


class BrandController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $groupByLetter = (bool) $request->input('group_by_letter', false);

        $brands = Brand::query()->active()->get();

        if ($brands->isEmpty()) {
            return notFound('No brands found.');
        }

        if ($groupByLetter) {
            $groups = [
                'A' => ['A'],
                'B-G' => ['B', 'C', 'D', 'E', 'F', 'G'],
                'H-N' => ['H', 'I', 'J', 'K', 'L', 'M', 'N'],
                'O-R' => ['O', 'P', 'Q', 'R'],
                'S' => ['S'],
                'T-Z' => ['T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
            ];

            $groupedBrands = collect();
            foreach (array_keys($groups) as $group) {
                $groupedBrands[$group] = collect();
            }

            foreach ($brands as $brand) {
                $firstLetter = strtoupper(Str::substr($brand->title ?? '', 0, 1));

                if (empty($firstLetter) || !preg_match('/^[A-Z]$/', $firstLetter)) {
                    $groupedBrands['A']->push($brand);
                    continue;
                }

                $group = 'T-Z';
                foreach ($groups as $groupName => $letters) {
                    if (in_array($firstLetter, $letters)) {
                        $group = $groupName;
                        break;
                    }
                }

                $groupedBrands[$group]->push($brand);
            }

            $groupedBrands = $groupedBrands->map(fn ($brands) => BrandResource::collection($brands));
        } else {
            $groupedBrands = BrandResource::collection($brands);
        }

        return success('Brands retrieved successfully.', $groupedBrands);
    }
}