<?php

namespace App\Services\News;

use App\Models\Author;
use App\Models\Category;
use App\Services\News\Abstracts\AbstractNewsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NyTimesService extends AbstractNewsService
{

    private string $url;

    private string $key;

    public function __construct()
    {
        $this->url = config('services.ny-times.url');
        $this->key = config('services.ny-times.key');
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
            ->get($this->url . '/topstories/v2/home.json', [
                'api-key' => $this->key
            ]);

        $response->throwIf(!$response->successful());

        return $response->json();
    }

    protected function cleanData(array $data): array
    {
        $newsSourceId = $this->getNewsSourceId('New York Times');

        return array_map(function ($news) use ($newsSourceId) {
            $author = $this->createOrFindModel(Author::class, ['name' => $news['byline']]);
            $category = $this->createOrFindModel(Category::class, ['name' => $news['section']]);

            return [
                'news_source_id' => $newsSourceId,
                'secondary_news_source' => null,
                'author_id' => $author->id,
                'category_id' => $category->id,
                'title' => $news['title'],
                'description' => $news['abstract'],
                'content' => null,
                'secondary_news_url' => null,
                'image_url' => $news['multimedia'][0]['url'] ?? null,
                'published_at' => Carbon::parse($news['published_date'])->toDateTimeString(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $data['results']);
    }
}
