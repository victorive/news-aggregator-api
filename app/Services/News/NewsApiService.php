<?php

namespace App\Services\News;

use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use App\Models\NewsSource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class NewsApiService
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
        $data = $this->getData('bitcoin');
        $data = $this->cleanData($data);

        $dataChunk = collect($data)->chunk(5000);

        foreach ($dataChunk as $chunk) {
            $this->storeData($chunk->toArray());
        }
    }

    private function getData(string $searchTerm): array
    {
        $response = Http::accept('application/json')
            ->withToken($this->key)
            ->get($this->url . '/everything?q=' . $searchTerm);

        return $response->json();
    }

    private function cleanData(array $data): array
    {
        $newsSourceId = $this->getNewsSourceId('NewsAPI.org');

        return array_map(function ($news) use ($newsSourceId) {
            $author = $this->createOrFindModel(Author::class, ['name' => $news['author']]);
            $category = $this->createOrFindModel(Category::class, ['name' => $news['category']]);

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

    private function getNewsSourceId(string $sourceName): int
    {
        return NewsSource::where('name', $sourceName)->value('id');
    }

    private function createOrFindModel($model, $data)
    {
        return $model::firstOrCreate($data);
    }

    private function storeData(array $news): void
    {
        DB::beginTransaction();

        News::insert($news);

        DB::commit();
    }
}
