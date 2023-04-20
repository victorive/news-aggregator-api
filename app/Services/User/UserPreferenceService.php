<?php

namespace App\Services\User;

use App\Models\User;

class UserPreferenceService
{
    public function saveUserNewsSourcesPreferences(int $userId, array $newsSourcesId, array $categoryId, array $authorId): void
    {
        $user = User::find($userId);

        if (!$user) {
            throw new \Exception('User not found');
        }

        $user->newsSources()->sync($newsSourcesId);
        $user->categories()->sync($categoryId);
        $user->authors()->sync($authorId);
    }
}
