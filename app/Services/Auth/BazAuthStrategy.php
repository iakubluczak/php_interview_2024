<?php

namespace App\Services\Auth;

use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;

class BazAuthStrategy implements AuthStrategy
{
    private $authService;

    public function __construct()
    {
        $this->authService = new Authenticator();
    }

    public function authenticate(string $login, string $password): bool
    {
        $response = $this->authService->auth($login, $password);
        return $response instanceof Success;
    }
}