<?php

namespace App\Services\News\Abstracts;

use App\Models\News;
use App\Models\NewsSource;
use Illuminate\Support\Facades\DB;

abstract class AbstractNewsService
{
    abstract public function __construct();

    public function processAndStoreData(): void
    {
        $data = $this->getData();
        $data = $this->cleanData($data);

        $this->storeData($data);
    }

    abstract protected function getData(): array;

    abstract protected function cleanData(array $data): array;

    protected function storeData(array $news): void
    {
        DB::beginTransaction();

        News::insert($news);

        DB::commit();
    }

    protected function getNewsSourceId(string $sourceName): int
    {
        return NewsSource::where('name', $sourceName)->value('id');
    }

    protected function createOrFindModel($model, $data)
    {
        return $model::firstOrCreate($data);
    }
}
