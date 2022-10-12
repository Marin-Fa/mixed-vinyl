<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MixRepository
{
    // Setting dependencies to properties
    //private $httpClient;
    //private $cache;

    // PHP8 new syntaxe
    /**
     * @param HttpClientInterface $httpClient
     * @param CacheInterface $cache
     * @param bool $isDebug
     */
    public function __construct(
        private HttpClientInterface $githubContentClient, // Fetching the named version of a service
        //private HttpClientInterface $httpClient,
        private CacheInterface $cache,
        #[Autowire('%kernel.debug%')] // Autowire PHP8 attribute
        private bool $isDebug, // autowiring only works for services, we need to configure services.yaml
        #[Autowire(service: 'twig.command.debug')]
        private DebugCommand $twigDebugCommand,

    )
    {
        // Adding dependencies
        //$this->httpClient = $httpClient;
        //$this->cache = $cache;
    }

    public function findAll(): array
    {
        $output = new BufferedOutput();
        $this->twigDebugCommand->run(new ArrayInput([]), $output);
        //dd($output);

        return $this->cache->get('mixes_data', function(CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter($this->isDebug ? 5 : 60);
            //$cacheItem->expiresAfter(5);
            $response = $this->githubContentClient->request('GET', '/SymfonyCasts/vinyl-mixes/main/mixes.json');

            return $response->toArray();
        });
    }
}