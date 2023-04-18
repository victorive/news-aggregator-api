<?php

namespace App\Services\News;

use App\Models\Author;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsApiService extends NewsServiceAbstract
{
    private string $url;

    private string $key;

    public function __construct()
    {
        $this->url = config('services.news-api.url');
        $this->key = config('services.news-api.key');
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
            ->get($this->url . '/top-headlines?country=gb&pageSize=100');

        return $response->json();
    }

    protected function cleanData(array $data): array
    {
        $newsSourceId = $this->getNewsSourceId('NewsAPI.org');

        return array_map(function ($news) use ($newsSourceId) {
            $author = $this->createOrFindModel(Author::class, ['name' => $news['author']]);
//            $category = $this->createOrFindModel(Category::class, ['name' => $news['category']]);

            return [
                'news_source_id' => $newsSourceId,
                'secondary_news_source' => $news['source']['name'],
                'author_id' => $author->id ?? 1,
                'category_id' => 1,
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
