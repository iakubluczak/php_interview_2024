<?php

namespace App\Services\Movies;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MovieServiceFacade
{
    private array $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }

    public function getAllTitles(): array
    {
        $cacheKey = 'merged_movie_titles';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $allTitles = [];

        foreach ($this->services as $service) {
            try {
                $titles = $this->fetchWithRetry(function () use ($service) {
                    return $service->getTitles();
                });
                $allTitles = array_merge($allTitles, $titles);
            } catch (\RuntimeException $e) {
                Log::error($e->getMessage());
            }
        }

        Cache::put($cacheKey, $allTitles, now()->addMinutes(10));

        return $allTitles;
    }

    private function fetchWithRetry(callable $fetchFunction, int $retries = 3)
    {
        for ($i = 0; $i < $retries; $i++) {
            try {
                return $fetchFunction();
            } catch (\RuntimeException $e) {
                if ($i == $retries - 1) {
                    throw $e;
                }
            }
        }
    }
}