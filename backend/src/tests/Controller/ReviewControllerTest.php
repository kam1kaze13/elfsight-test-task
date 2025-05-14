<?php

use App\DataFixtures\EpisodeFixture;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReviewControllerTest extends WebTestCase
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
        $this->client->request('POST', '/api/review/submit/4124214');
        self::assertResponseStatusCodeSame(404);

        $this->client->request('POST', '/api/review/submit/1');
        self::assertResponseStatusCodeSame(400);

        $this->client->request('POST', '/api/review/submit/1', ['text' => 'I like it!']);
        self::assertResponseIsSuccessful('Review submitted successfully');
    }
}
