<?php

namespace App\Services\News;

use App\Models\Author;
use App\Models\Category;
use App\Services\News\Abstracts\AbstractNewsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TheGuardianService extends AbstractNewsService
{
    private string $url;

    private string $key;

    public function __construct()
    {
        $this->url = config('services.the-guardian.url');
        $this->key = config('services.the-guardian.key');
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
            ->get($this->url . '/search?', [
                'api-key' => $this->key,
                'pageSize' => 100,
                'show-fields' => 'byline,headline,thumbnail,trailText'
            ]);

        $response->throwIf(!$response->successful());

        return $response->json();
    }

    protected function cleanData(array $data): array
    {
        $newsSourceId = $this->getNewsSourceId('The Guardian');

        return array_map(function ($news) use ($newsSourceId) {
            $author = $this->createOrFindModel(Author::class, ['name' => $news['fields']['byline']]);
            $category = $this->createOrFindModel(Category::class, ['name' => $news['pillarName']]);

            return [
                'news_source_id' => $newsSourceId,
                'secondary_news_source' => null,
                'author_id' => $author->id,
                'category_id' => $category->id,
                'title' => $news['fields']['headline'],
                'description' => null,
                'content' => null,
                'secondary_news_url' => null,
                'image_url' => $news['fields']['thumbnail'] ?? null,
                'published_at' => Carbon::parse($news['webPublicationDate'])->toDateTimeString(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $data['response']['results']);
    }
}
