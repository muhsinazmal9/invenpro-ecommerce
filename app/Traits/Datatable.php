<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Datatable
{
    public static function datatable(Request $request, array $columns, array $options = []): array
    {
        $options = array_merge([
            'searchables' => [],
            'defaultOrderBy' => 'id',
            'defaultOrderDir' => 'desc',
            'with' => [],
            'modifyQuery' => fn($query) => $query,
            'formatRow' => fn($row, $model) => $row,
        ], $options);

        $query = static::query();

        // Eager load relations
        if (!empty($options['with'])) {
            $query->with($options['with']);
        }

        // Optional dynamic filters (like low stock, top product)
        $query = call_user_func($options['modifyQuery'], $query);

        $total = $query->count();

        // Search
        $search = $request->input('search.value', '');
        if ($search) {
            $query->where(function ($q) use ($search, $options) {
                foreach ($options['searchables'] as $field) {
                    if (str_contains($field, '.')) {
                        [$relation, $column] = explode('.', $field);
                        $q->orWhereHas($relation, fn($sub) => $sub->where($column, 'like', "%{$search}%"));
                    } else {
                        $q->orWhere($field, 'like', "%{$search}%");
                    }
                }

                // // status toggle example
                // if (strtolower($search) === 'enabled') {
                //     $q->orWhere('status', true);
                // }
                // if (strtolower($search) === 'disabled') {
                //     $q->orWhere('status', false);
                // }
            });
        }

        $filtered = $query->count();

        // Order
        $columnsList = array_values($columns);
        $orderIndex = $request->input('order.0.column', 0);
        $orderColumn = $columnsList[$orderIndex] ?? $options['defaultOrderBy'];
        if (in_array($orderColumn, ['actions', 'thumbnail'])) {
            $orderColumn = $options['defaultOrderBy'];
        }

        $orderDirection = $request->input('order.0.dir', $options['defaultOrderDir']);
        $query->orderBy($orderColumn, $orderDirection);

        // Pagination
        $query->skip($request->input('start', 0))
              ->take($request->input('length', 10));

        $data = [];
        foreach ($query->get() as $index => $model) {
            $row = [];
            foreach ($columns as $col) {
                $row[$col] = data_get($model, $col);
            }

            $data[] = call_user_func($options['formatRow'], $row, $model, $index);
        }
        info('data', $data);
        return [
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ];
    }
}
