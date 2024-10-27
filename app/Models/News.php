<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    protected $fillable = [
        'provider',
        'title',
        'url',
        'published_at'
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function currencies(): BelongsToMany
    {
        return $this->belongsToMany(Currency::class, 'news_currencies');
    }
}
