<?php

namespace App\Services;

use App\Factories\NewsProviderFactory;
use App\Repositories\CurrencyRepository;
use App\Repositories\NewsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class NewsServiceManager
{
    public array $providers = [
        CryptoPanic::class,
    ];

    public function __construct(
        private NewsRepository $newsRepository,
        private CurrencyRepository $currencyRepository,
    ) {}

    public function handle(): void
    {
        $data = [];

        foreach ($this->providers as $providerName) {
            $provider = NewsProviderFactory::create($providerName);
            $lastFetchedNews = $this->newsRepository->latest($provider::NAME);
            $lastFetchedNewsDateTime = $lastFetchedNews ? Carbon::parse($lastFetchedNews->published_at) : null;
            $data[] = $provider->fetch($lastFetchedNewsDateTime);
        }

        $data = array_merge(...$data);

        foreach ($data as $result) {
            $currencies = [];

            $news = $this->newsRepository
                ->save(
                    $result->provider,
                    $result->title,
                    $result->url,
                    $result->publishedAt,
                );

            if ($news && $result->currencies) {
                foreach ($result->currencies as $_currency) {
                    $currency = $this->currencyRepository->save($_currency['code']);
                    $currencies[] = $currency->id;
                }

                $this->newsRepository->attachCurrencies($news, $currencies);
            }
        }

        if(!empty($data)) {
            Cache::tags(['currencies', 'news'])->flush();
        }
    }
}
