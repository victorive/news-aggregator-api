<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function __invoke(Request $request): JsonResource
    {
        return UserProfileResource::make($request->user());
    }
}
