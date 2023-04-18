<?php

namespace App\Http\Resources\News;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'news_source' => $this->news_source_name,
            'secondary_news_source' => $this->secondary_news_source,
            'author' => $this->author_name,
            'category' => $this->category_name,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'secondary_news_url' => $this->secondary_news_url,
            'image_url' => $this->image_url,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
