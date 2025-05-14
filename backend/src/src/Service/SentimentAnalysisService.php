<?php

namespace App\Service;

use Sentiment\Analyzer;

class SentimentAnalysisService
{
    private Analyzer $analyzer;

    public function __construct()
    {
        $this->analyzer = new Analyzer();
    }

    public function getSentimentPosValue(string $text): float
    {
        return $this->analyzer->getSentiment($text)['pos'] ?? 0.00;
    }
}
