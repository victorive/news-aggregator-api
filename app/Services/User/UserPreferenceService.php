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

        $pivotData = [];

        foreach ($newsSourcesId as $key => $newsSourceId) {
            $category = $categoryId[$key] ?? null;
            $author = $authorId[$key] ?? null;
            $pivotData[$newsSourceId] = [
                'category_id' => $category,
                'author_id' => $author,
            ];
        }

        $user->newsSources()->sync($pivotData);
    }
}
