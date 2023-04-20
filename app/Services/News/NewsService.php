<?php

namespace App\Services\News;

use App\Http\Filters\News\AuthorFilter;
use App\Http\Filters\News\CategoryFilter;
use App\Http\Filters\News\NewsSourceFilter;
use App\Models\News;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class NewsService
{
    public function getNews(array $authors, array $categories, array $newsSources): Collection
    {
        return QueryBuilder::for(News::class)
            ->with(['author', 'category', 'newsSource'])
            ->where(function ($query) use ($authors, $categories, $newsSources) {
                $query->whereIn('author_id', $authors)
                    ->orWhereIn('category_id', $categories)
                    ->orWhereIn('news_source_id', $newsSources);
            })
            ->allowedFilters([
                AllowedFilter::custom('author_id', new AuthorFilter()),
                AllowedFilter::custom('category_id', new CategoryFilter()),
                AllowedFilter::custom('news_source_id', new NewsSourceFilter()),
            ])
            ->get();
    }
}
