<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\NewsSourceResource;
use App\Models\NewsSource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsSourcesController extends Controller
{
    public function __invoke(): JsonResource
    {
        return NewsSourceResource::collection(NewsSource::all());
    }
}
