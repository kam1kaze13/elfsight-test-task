<?php

namespace Tests\Service;

use App\Service\SentimentAnalysisService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SentimentAnalysisServiceTest extends KernelTestCase
{
    private SentimentAnalysisService $service;

    public function setUp(): void
    {
        self::bootKernel();

        $this->service = self::getContainer()->get(SentimentAnalysisService::class);
    }

    public function testGetPosSentiment(): void
    {
        $result = $this->service->getSentimentPosValue('the episode is just great');

        $this->assertGreaterThanOrEqual(0.5, $result);
    }

    public function testGetNegSentiment(): void
    {
        $result = $this->service->getSentimentPosValue('the most horrible episode i have ever watched');

        $this->assertLessThanOrEqual(0.3, $result);
    }
}
