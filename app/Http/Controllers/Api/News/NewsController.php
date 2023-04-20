<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
use App\Http\Filters\News\AuthorFilter;
use App\Http\Filters\News\CategoryFilter;
use App\Http\Filters\News\NewsSourceFilter;
use App\Http\Resources\News\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class NewsController extends Controller
{
    public function __invoke(Request $request): JsonResource
    {
        $user = $request->user();

        $authors = $user->authors->pluck('id')->toArray();
        $categories = $user->categories->pluck('id')->toArray();
        $newsSources = $user->newsSources->pluck('id')->toArray();

        $news = QueryBuilder::for(News::class)
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

        return NewsResource::collection($news);
    }
}
