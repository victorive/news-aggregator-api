<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorController extends Controller
{
    public function __invoke(): JsonResource
    {
        return AuthorResource::collection(Author::all());
    }
}
