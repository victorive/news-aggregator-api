<?php

namespace App\Console\Commands\Services;

use App\Services\News\NyTimesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NyTimesServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:ny-times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the New York Times service';

    public function __construct(private readonly NyTimesService $nyTimesService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info('New York Times service starting...');

        try {
            $this->nyTimesService->processAndStoreData();

            Log::info('New York Times service ran successfully');
        } catch (\Exception $exception) {
            Log::info('Error calling New York Times service: ' . $exception->getMessage());
        }

        Log::info('New York Times service finished');
    }
}
