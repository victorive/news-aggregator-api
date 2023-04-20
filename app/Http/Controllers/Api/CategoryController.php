<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    public function __invoke(): JsonResource
    {
        return CategoryResource::collection(Category::all());
    }
}
