<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserPreferencesTest extends TestCase
{
    private string $url = 'api/v1/preferences';

    public function testUserCanSetPreferences(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->postJson($this->url, [
            "news_source_id" => [1, 2],
            "category_id" => [1, 2],
            "author_id" => [1, 2]
        ])->assertCreated()
            ->assertJson([
                'message' => 'Preferences saved',
            ]);
    }
}
