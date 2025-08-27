<?php

namespace App\Services\SocialApi;

interface SocialApiStrategyInterface
{
    public function fetchUserData(string $username): array;
}