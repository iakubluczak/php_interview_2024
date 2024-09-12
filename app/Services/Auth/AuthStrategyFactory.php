<?php

namespace App\Services\Auth;

class AuthStrategyFactory
{
    public static function createStrategy(string $login): ?AuthStrategy
    {
        $strategies = [
            'FOO_' => FooAuthStrategy::class,
            'BAR_' => BarAuthStrategy::class,
            'BAZ_' => BazAuthStrategy::class,
        ];

        foreach ($strategies as $prefix => $strategyClass) {
            if (strpos($login, $prefix) === 0) {
                return new $strategyClass();
            }
        }

        return null;
    }
}