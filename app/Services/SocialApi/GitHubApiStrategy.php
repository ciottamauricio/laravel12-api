<?php

namespace App\Services\SocialApi;

use Illuminate\Support\Facades\Http;

class GitHubApiStrategy implements SocialApiStrategyInterface
{
    public function fetchUserData(string $username): array
    {
        $response = Http::get("https://api.github.com/users/{$username}");

        //$response = Http::get("https://api.github.com/users/ciottamauricio/following/{$username}");        

        if ($response->failed()) {
            throw new \Exception("GitHub user not found.");
        }

        return $response->json();
    }
}