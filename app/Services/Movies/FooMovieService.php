<?php

namespace App\Services\Movies;

use External\Foo\Movies\MovieService as ExternalFooService;
use External\Foo\Exceptions\ServiceUnavailableException;

class FooMovieService implements MovieServiceInterface
{
    private $fooService;

    public function __construct()
    {
        $this->fooService = new ExternalFooService();
    }

    public function getTitles(): array
    {
        try {
            return $this->fooService->getTitles();
        } catch (ServiceUnavailableException $e) {
            throw new \RuntimeException('Service unavailable for Foo');
        }
    }
}