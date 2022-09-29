<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use symfony\component\string\u;

class VinylController
{
    #[Route('/')]
    public function homepage(): Response
    {
        // A controller should return a Response object of HTTPfoundation
        return new Response('Title: PB and Jams');
    }

    //#[Route('/browse/{slug}')]
//    public function browse(string $slug): Response
//    {
//        $title = u(str_replace('-', ' ', $slug))->title(true);
//        return new Response('Genre: ' . $title);
//
//    }

}