<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        if (!Auth::attempt(['email' => $request->validated('email'), 'password' => $request->validated('password')])) {
            return response()->json([
                'message' => 'Invalid email or password, please try again'
            ], 401);
        }

        $user = Auth::user();

        if ($user instanceof User) {

            $token = $user->createToken('token')->plainTextToken;
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }
}
