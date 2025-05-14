<?php

use App\DataFixtures\EpisodeFixture;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EpisodeControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $episodeFixture = new EpisodeFixture();
        $episodeFixture->load($entityManager);
    }

    public function testSubmitReview(): void
    {
        $this->client->request('GET', '/api/episode/summary/1234214325');
        self::assertResponseStatusCodeSame(404);

        $this->client->request('GET', '/api/episode/summary/1');
        $response = $this->client->getResponse();
        self::assertResponseIsSuccessful();

        $data = json_decode($response->getContent(), true);
        self::assertArrayHasKey('name', $data);
        self::assertArrayHasKey('airDate', $data);
        self::assertArrayHasKey('avgSentimentScore', $data);
        self::assertArrayHasKey('reviews', $data);
    }
}
