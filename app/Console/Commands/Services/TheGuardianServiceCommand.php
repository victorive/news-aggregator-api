<?php

namespace App\Console\Commands\Services;

use App\Services\News\TheGuardianService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TheGuardianServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:the-guardian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run The Guardian service';

    public function __construct(private readonly TheGuardianService $theGuardianService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info('The Guardian service starting...');

        try {
            $this->theGuardianService->processAndStoreData();

            Log::info('The Guardian service ran successfully');
        } catch (\Exception $exception) {
            Log::info('Error calling The Guardian service: ' . $exception->getMessage());
        }

        Log::info('The Guardian service command finished');
    }
}
