<?php

namespace App\Services\Movies;

use External\Baz\Movies\MovieService as ExternalBazService;
use External\Baz\Exceptions\ServiceUnavailableException;

class BazMovieService implements MovieServiceInterface
{
    private $bazService;

    public function __construct()
    {
        $this->bazService = new ExternalBazService();
    }

    public function getTitles(): array
    {
        try {
            $response = $this->bazService->getTitles();
            return $response['titles'];
        } catch (ServiceUnavailableException $e) {
            throw new \RuntimeException('Service unavailable for Baz');
        }
    }
}