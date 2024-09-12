<?php

namespace App\Services\Movies;

use External\Bar\Movies\MovieService as ExternalBarService;
use External\Bar\Exceptions\ServiceUnavailableException;

class BarMovieService implements MovieServiceInterface
{
    private $barService;

    public function __construct()
    {
        $this->barService = new ExternalBarService();
    }
    public function getTitles(): array
    {
        try {
            $response = $this->barService->getTitles();
            return array_column($response['titles'], 'title');
        } catch (ServiceUnavailableException $e) {
            throw new \RuntimeException('Service unavailable for Bar');
        }
    }
}