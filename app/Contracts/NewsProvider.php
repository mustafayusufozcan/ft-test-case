<?php

namespace App\Contracts;

use App\Dto\NewsDto;
use DateTimeInterface;

interface NewsProvider
{
    /**
     * @param DateTimeInterface|null $lastFetchedNewsDateTime
     * 
     * @return array<id,NewsDto>
     */
    public function fetch(?DateTimeInterface $lastFetchedNewsDateTime = null): array;
}
