<?php

namespace App\Services\Auth;

use External\Bar\Auth\LoginService;

class BarAuthStrategy implements AuthStrategy
{
    private $authService;

    public function __construct()
    {
        $this->authService = new LoginService();
    }

    public function authenticate(string $login, string $password): bool
    {
        return $this->authService->login($login, $password);
    }
}