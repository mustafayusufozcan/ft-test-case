<?php

namespace App\Repositories;

use App\Models\News;
use Exception;
use Illuminate\Support\Facades\Log;

class NewsRepository
{
    public function __construct(private $model = new News) {}

    public function save(string $providerKey, string $title, string $url, string $publishedAt): ?News
    {
        try {
            return $this->model->create([
                'provider' => $providerKey,
                'title' => $title,
                'url' => $url,
                'published_at' => $publishedAt
            ]);
        } catch (Exception $e) {
            Log::channel('repository')->error(sprintf('Failed to save data for %s - %s: %s.', $providerKey, $title, $e->getMessage()));
        }

        return null;
    }

    public function attachCurrencies(News $news, array $currencies): void
    {
        $news->currencies()->sync($currencies);
    }

    public function latest(string $providerKey): ?News
    {
        return $this->model->where('provider', $providerKey)->orderByDesc('published_at')->first();
    }
}
