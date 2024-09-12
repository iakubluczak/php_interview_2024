<?php

namespace App\Services\Auth;

use External\Foo\Auth\AuthWS;

class FooAuthStrategy implements AuthStrategy
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthWS();
    }
    public function authenticate(string $login, string $password): bool
    {
        try {
            $this->authService->authenticate($login, $password);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}