<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
use App\Http\Filters\News\AuthorFilter;
use App\Http\Filters\News\CategoryFilter;
use App\Http\Filters\News\NewsSourceFilter;
use App\Http\Resources\News\NewsResource;
use App\Models\News;
use App\Services\News\NewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Exceptions\InvalidFieldQuery;
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
use Spatie\QueryBuilder\QueryBuilder;

class NewsController extends Controller
{
    public function __construct(private readonly NewsService $newsService)
    {
    }

    public function __invoke(Request $request): JsonResource|JsonResponse
    {
        $user = $request->user();

        $authors = $user->authors->pluck('id')->toArray();
        $categories = $user->categories->pluck('id')->toArray();
        $newsSources = $user->newsSources->pluck('id')->toArray();

        try {
            $news = $this->newsService->getNews($authors, $categories, $newsSources);

            if ($news->isEmpty()) {
                return response()->json([
                    'message' => 'No news found',
                ]);
            }
        } catch (InvalidFilterQuery $invalidFilterQuery) {

            Log::error($invalidFilterQuery);

            return response()->json([
                'message' => 'Invalid filter'
            ]);
        }

        return NewsResource::collection($news);
    }
}
