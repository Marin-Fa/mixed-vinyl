<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SongController extends AbstractController
{
    // the route should only take a wildcard number
    // that would gave a 500 error server
    // that'll gave a 404 error that's better
    #[Route('/api/songs/{id</d+>}', methods: ['GET'])]
    public function getSong(int $id, LoggerInterface $logger): Response
    {
        $song = [
            'id' => $id,
            'name' => 'Waterfalls',
            'url' => 'https://symfonycasts.s3.amazonaws.com/sample.mp3',
        ];

        $logger->info('Returning API Response for song {song}' . $id, [
            'song' => $id,
        ]);
        // json encode
        return new JsonResponse($song);
    }
}