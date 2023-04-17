<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
use App\Services\News\NewsApiService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        private readonly NewsApiService $newsApiService
    )
    {
    }
}
