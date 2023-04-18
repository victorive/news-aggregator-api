<?php

namespace App\Services\News;

use App\Models\Author;
use App\Models\Category;
use App\Services\News\Abstracts\AbstractNewsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsApiService extends AbstractNewsService
{
    public function __construct()
    {
        parent::__construct(config('services.news-api.url'), config('services.news-api.key'));
    }

    public function processAndStoreData(): void
    {
        $data = $this->getData();
        $data = $this->cleanData($data);

        $this->storeData($data);
    }

    protected function getData(): array
    {
        $response = Http::accept('application/json')
            ->withToken($this->key)
            ->get($this->url . '/top-headlines?country=gb&pageSize=100&category=general');

        $response->throwIf(!$response->successful());

        return $response->json();
    }

    protected function cleanData(array $data): array
    {
        $newsSourceId = $this->getNewsSourceId('NewsAPI.org');

        return array_map(function ($news) use ($newsSourceId) {
            $author = $this->createOrFindModel(Author::class, ['name' => $news['author']]);
            $category = $this->createOrFindModel(Category::class, ['name' => 'general']);

            return [
                'news_source_id' => $newsSourceId,
                'secondary_news_source' => $news['source']['name'],
                'author_id' => $author->id,
                'category_id' => $category->id,
                'title' => $news['title'],
                'description' => $news['description'],
                'content' => $news['content'],
                'secondary_news_url' => $news['url'],
                'image_url' => $news['urlToImage'],
                'published_at' => Carbon::parse($news['publishedAt'])->toDateTimeString(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $data['articles']);
    }
}
