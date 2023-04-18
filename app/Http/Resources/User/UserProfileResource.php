<?php

namespace App\Http\Resources\User;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'preferences' => [
                'authors' => $this->newsSources->map(function ($newsSource) {
                    $author = Author::find($newsSource->pivot->author_id);
                    return [
                        'id' => $newsSource->pivot->author_id,
                        'name' => $author->name ?? null
                    ];
                }),
                'news-sources' => $this->newsSources->map(function ($newsSources) {
                    return [
                        'id' => $newsSources->id,
                        'name' => $newsSources->name
                    ];
                }),
                'categories' => $this->newsSources->map(function ($newsSource) {
                    $category = Category::find($newsSource->pivot->category_id);
                    return [
                        'id' => $newsSource->pivot->category_id,
                        'name' => $category->name ?? null
                    ];
                }),
            ],
        ];
    }
}
