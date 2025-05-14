<?php

namespace Tests\Service;

use App\Service\RickAndMortyApiService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RickAndMortyApiServiceTest extends KernelTestCase
{
    private RickAndMortyApiService $service;

    public function setUp(): void
    {
        self::bootKernel();

        $this->service = self::getContainer()->get(RickAndMortyApiService::class);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testGetListOfEpisodes(): void
    {
        $episodes = $this->service->getListOfEpisodes()['episodes'];

        $this->assertNotEmpty($episodes);

        $firstEpisode = $episodes[0];
        $this->assertIsArray($firstEpisode);

        $this->assertArrayHasKey('id', $firstEpisode);
        $this->assertArrayHasKey('name', $firstEpisode);
        $this->assertArrayHasKey('air_date', $firstEpisode);
        $this->assertArrayHasKey('episode', $firstEpisode);
    }
}
