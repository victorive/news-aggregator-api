<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
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
            ->allowedFilters([
                'author_id',
                'category_id',
                'news_source_id',
            ])
            ->with(['author', 'category', 'newsSource'])
            ->whereIn('author_id', $authors)
            ->orWhereIn('category_id', $categories)
            ->orWhereIn('news_source_id', $newsSources)
            ->get();

        return NewsResource::collection($news);
    }
}
