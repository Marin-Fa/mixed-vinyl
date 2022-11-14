<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
//use App\Service\MixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    public  function __construct(
        private bool $isDebug,
        //private MixRepository $mixRepository
    )
    {

    }

    #[Route('/mix/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Do you Remember... Phil Collins?!');
        $mix->setDescription('A pure mix of drummers turned singers!');
        $genres = ['pop', 'rock'];
        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));

        $entityManager->persist($mix);
        $entityManager->flush();

        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80\'s heaven',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }

    #[Route('/mix/{id}', name: 'app_mix_show')]
    // For this to work, we need to install a new bundle sensio/framework-extra-bundle
    public function show(VinylMix $mix): Response
    {
        return $this->render('vinyl/show.html.twig', [
            'mix' => $mix,
        ]);
    }
//    public function show($id, VinylMixRepository $mixRepository): Response
//    {
//        $mix = $mixRepository->find($id);
//
//        if (!$mix) {
//            throw $this->createNotFoundException('Mix not found');
//        }
//
//        return $this->render('vinyl/show.html.twig', [
//            'mix' => $mix,
//        ]);
//    }

    #[Route('/', name: 'app_homepage')]
    public function homepage(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];

        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks,
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        //$mixes = $mixRepository->findAll();
        $mixes = $mixRepository->findAllOrderedByVotes($slug);
        //$mixes = $mixRepository->findBy([], ['votes' => 'DESC']);

        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }

//    public function browse(HttpClientInterface $httpClient, CacheInterface $cache, MixRepository $mixRepository, bool $isDebug, string $slug = null): Response
//    {
//        dump($this->isDebug);
//        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
//        // Using the service MixRepository
//        $mixes = $this->mixRepository->findAll();
//
//        return $this->render('vinyl/browse.html.twig', [
//            'genre' => $genre,
//            'mixes' => $mixes,
//        ]);
//    }

    #[Route('/mix/{id}/vote', name: 'app_mix_vote')]
    // Request is not a Service
    public function vote(VinylMix $mix, Request $request, EntityManagerInterface $entityManager): Response
    {
        $direction = $request->request->get('direction', 'up');
        if ($direction === 'up') {
            $mix->setVotes($mix->getVotes() + 1);
        } else {
            $mix->setVotes($mix->getVotes() - 1);
        }
        //dd($mix);

        $entityManager->flush();

        return $this->redirectToRoute('app_mix_show', [
            'id' => $mix->getId(),
        ]);
    }

    private function getMixes(): array
    {
        // temporary fake "mixes" data
        return [
            [
                'title' => 'PB & Jams',
                'trackCount' => 14,
                'genre' => 'Rock',
                'createdAt' => new \DateTime('2021-10-02'),
            ],
            [
                'title' => 'Put a Hex on your Ex',
                'trackCount' => 8,
                'genre' => 'Heavy Metal',
                'createdAt' => new \DateTime('2022-04-28'),
            ],
            [
                'title' => 'Spice Grills - Summer Tunes',
                'trackCount' => 10,
                'genre' => 'Pop',
                'createdAt' => new \DateTime('2019-06-20'),
            ],
        ];
    }
}
