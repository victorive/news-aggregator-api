<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $guarded = ['id'];

    public function scopeDateBetween(Builder $query, ...$date): Builder
    {
        [$startDate, $endDate] = $date;

        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function newsSource(): BelongsTo
    {
        return $this->belongsTo(NewsSource::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getNewsSourceNameAttribute(): ?string
    {
        return optional($this->newsSource)->name;
    }

    public function getAuthorNameAttribute(): ?string
    {
        return optional($this->author)->name;
    }

    public function getCategoryNameAttribute(): ?string
    {
        return optional($this->category)->name;
    }
}
