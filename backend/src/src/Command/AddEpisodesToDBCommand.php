<?php

namespace App\Command;

use App\Entity\Episode;
use App\Service\RickAndMortyApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand('add:episodes:db')]
class AddEpisodesToDBCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly RickAndMortyApiService $rickAndMortyApiService,
    ) {
        parent::__construct();
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $page = 1;
        while (true) {
            $episodes = $this->rickAndMortyApiService->getListOfEpisodes($page);
            if ($episodes['info']['next'] === null || isset($episodes['error'])) {
                break;
            }

            foreach ($episodes['episodes'] as $episode) {
                $existEpisode = $this->entityManager->getRepository(Episode::class)->find($episode['id']);

                if (!isset($existEpisode)) {
                    $newEpisode = new Episode();
                    $newEpisode->setName($episode['name']);
                    $newEpisode->setAirDate($episode['air_date']);

                    $this->entityManager->persist($newEpisode);
                    $this->entityManager->flush();
                }
            }

            ++$page;
        }

        $this->entityManager->clear();

        return Command::SUCCESS;
    }
}
