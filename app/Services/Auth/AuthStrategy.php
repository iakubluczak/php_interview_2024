<?php

namespace App\Services\Auth;

interface AuthStrategy
{
    public function authenticate(string $login, string $password): bool;
}