<?php

namespace App\Console\Commands\Services;

use App\Services\News\NewsApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NewsApiServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:news-api';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the NewsAPI.org service';

    public function __construct(private readonly NewsApiService $newsApiService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info('NewsAPI.org service starting...');

        try {
            $this->newsApiService->processAndStoreData();

            Log::info('NewsAPI.org service ran successfully');
        } catch (\Exception $exception) {
            Log::info('Error calling NewsAPI.org service: ' . $exception->getMessage());
        }

        Log::info('NewsAPI.org service finished');
    }
}
