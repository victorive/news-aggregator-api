<?php

namespace App\Http\Filters\News;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\Filters\Filter;

class CategoryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_string($value)) {
            $value = Arr::wrap($value);
        }

        $query->where(function ($query) use (&$value) {
            $query->with(['category'])
                ->whereIn('category_id', $value);
        });
    }
}
