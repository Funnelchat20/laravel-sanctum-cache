<?php

namespace LaravelSanctumCache\Repositories;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class CustomTokenRepository
{
    protected Repository $cacheStore;

    public function __construct()
    {
        $this->cacheStore = Cache::store(env('SANCTUM_CACHE_STORE', 'default'));
    }

    public function create(HasApiTokens $user, string $name, array $abilities = ['*'], $expiresAt = null): NewAccessToken
    {
        $token = $user->createToken($name, $abilities, $expiresAt);

        $this->cacheStore->put($token->plainTextToken, $token->accessToken, $expiresAt);

        info('Token created and stored in cache');

        return $token;
    }

    public function findToken(string $token)
    {
        $cachedToken = $this->cacheStore->get($token);

        if ($cachedToken) {
            info('Token found in cache');
            return $cachedToken;
        }

        return PersonalAccessToken::findToken($token);
    }

    public function delete(PersonalAccessToken $token): void
    {
        $this->cacheStore->forget($token->token);
        $token->delete();
    }

    public function deleteExpired()
    {
        // Implement logic to delete expired tokens from cache and database
    }
}