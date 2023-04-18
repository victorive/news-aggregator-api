<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserPreferenceRequest;
use App\Models\User;
use App\Services\User\UserPreferenceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserPreferenceController extends Controller
{
    public function __construct(
        private readonly UserPreferenceService $userPreferenceService,
    ){}

    public function __invoke(UserPreferenceRequest $request): JsonResponse
    {
        $userId = $request->user()->id;
        $newsSourcesId = $request->input('news_source_id');
        $categoryId = $request->input('category_id');
        $authorId = $request->input('author_id');

        try {
            $this->userPreferenceService->saveUserNewsSourcesPreferences($userId, $newsSourcesId, $categoryId, $authorId);

            return response()->json([
                'message' => 'Preferences saved'
            ], 201);

        } catch (\Exception $exception) {
            Log::info($exception->getMessage());

            return response()->json([
                'message' => 'Failed to save preference',
            ], 422);
        }
    }
}
