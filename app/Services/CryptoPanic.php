<?php

namespace App\Services;

use App\Contracts\NewsProvider;
use App\Dto\NewsDto;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Facades\Http;

final class CryptoPanic implements NewsProvider
{
    const NAME = 'CRYPTO_PANIC';
    const API_URL = 'https://cryptopanic.com/api/v1';
    const API_KEY = '8ebb3171283d552adca5e1645aa37be96a1410c5';

    public function fetch(?DateTimeInterface $lastFetchedNewsDateTime = null): array
    {
        //NOTE: API servisi tarih filtrelemesi sunmadığı için $lastFetchedNewsDateTime değişkenini kullanmıyoruz.

        $url = self::API_URL . '/posts/?auth_token=' . self::API_KEY;
        $data = [];

        do {
            $response = Http::get($url)->throw()->json();

            foreach ($response['results'] as $item) {
                $data[] = new NewsDto(
                    self::NAME,
                    $item['title'],
                    $item['url'],
                    Carbon::parse($item['published_at'])->timezone(config('app.timezone')),
                    $item['currencies'] ?? [],
                );
            }

            //Response içinde sonraki sayfa için bağlantı varsa o sayfaya da git
            $url = $response['next'];
        } while ($url);

        return $data;
    }
}
