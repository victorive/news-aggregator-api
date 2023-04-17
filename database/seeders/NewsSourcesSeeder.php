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
        collect(['NewsAPI.org', 'The Guardian', 'New York Times'])
            ->map(function ($source) {
                NewsSource::firstOrCreate(['name' => $source]);
            });
    }
}
