<?php

namespace Database\Seeders;

use App\Models\NewsSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['NewsAPI', 'OpenNews', 'NewsCred', 'TheGuardian', 'New York Times', 'BBC News', 'NewsAPI.org'])
            ->map(fn($source) => NewsSource::firstOrCreate(['name' => $source]));
    }
}
