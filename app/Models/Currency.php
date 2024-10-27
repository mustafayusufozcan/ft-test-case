<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Currency extends Model
{
    protected $fillable = [
        'code',
    ];

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'news_currencies');
    }
}
