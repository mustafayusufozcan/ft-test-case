<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{
    public function __construct(private $model = new Currency) {}

    public function save(string $code): Currency
    {
        return $this->model->firstOrCreate([
            'code' => $code,
        ]);
    }
}
