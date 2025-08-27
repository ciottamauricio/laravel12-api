<?php

namespace App\Services\SocialApi;

class SocialApiFactory
{
    public static function make(string $provider): SocialApiStrategyInterface
    {
        return match ($provider) {
            'github' => new GitHubApiStrategy(),
//            'twitter' => new TwitterApiStrategy(),
            default => throw new \InvalidArgumentException("Unsupported provider: {$provider}"),
        };
    }
}