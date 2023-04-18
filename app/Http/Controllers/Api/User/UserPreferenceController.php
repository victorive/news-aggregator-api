<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserPreferenceRequest;
use App\Models\User;
use App\Services\User\UserPreferenceService;
use Illuminate\Http\JsonResponse;

class UserPreferenceController extends Controller
{
    public function __construct(
        private readonly UserPreferenceService $userPreferenceService,
    ){}

    public function __invoke(UserPreferenceRequest $request): JsonResponse
    {
        $userId = $request->user()->id;
        $newsSourcesId = $request->input('id');

        try {
            $this->userPreferenceService->saveUserNewsSourcesPreferences($userId, $newsSourcesId);

            return response()->json([
                'message' => 'Preferences saved'
            ], 201);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Failed to save preference',
                'error' => $exception->getMessage()
            ], 422);
        }
    }
}
