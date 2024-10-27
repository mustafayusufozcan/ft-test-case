<?php

namespace App\Factories;

use App\Contracts\NewsProvider;
use Exception;

class NewsProviderFactory
{
    public static function create(string $provider): NewsProvider
    {
        $service = app($provider);

        if (!$service instanceof NewsProvider) {
            throw new Exception(sprintf('Class %s does not implement NewsProvider!', $provider));
        }

        return $service;
    }
}
