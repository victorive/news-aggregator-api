<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\ShouldLogin;

class UserPreferencesTest extends TestCase
{
    use RefreshDatabase, ShouldLogin;

    private string $url = 'api/v1/preferences';

    public function testUserCanSavePreferences()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->postJson($this->url, [
            "news_source_id" => [1, 2],
            "category_id" => [1, 2],
            "author_id" => [1, 2]
        ])->assertOk()
            ->assertJson([
                'message' => 'Preferences saved',
            ]);
    }
}
