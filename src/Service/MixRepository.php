<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository
{
    // Setting dependencies to properties
    //private $httpClient;
    //private $cache;

    // PHP8 new syntaxe
    public function __construct(
        private HttpClientInterface $httpClient,
        private CacheInterface $cache)
    {
        // Adding dependencies
        //$this->httpClient = $httpClient;
        //$this->cache = $cache;
    }

    public function findAll(): array
    {
        return $this->cache->get('mixes_data', function(CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(5);
            $response = $this->httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');

            return $response->toArray();
        });
    }
}