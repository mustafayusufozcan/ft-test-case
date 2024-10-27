<?php

namespace App\Dto;

use DateTime;
use Illuminate\Contracts\Support\Arrayable;

readonly class NewsDto implements Arrayable
{
    public function __construct(
        public string $provider,
        public string $title,
        public string $url,
        public DateTime $publishedAt,
        public array $currencies = []
    ) {}

    public function toArray(): array
    {
        return [
            'provider' => $this->provider,
            'title' => $this->title,
            'url' => $this->url,
            'published_at' => $this->publishedAt,
            'currencies' => $this->currencies
        ];
    }
}
