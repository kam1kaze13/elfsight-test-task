<?php

namespace App\Controller;

use App\Entity\Episode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class EpisodeController
{
    #[Route(path: '/api/episode/summary/{id}', methods: ['GET'])]
    public function getEpisodeSummary(
        int $id,
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $episode = $entityManager->getRepository(Episode::class)->find($id);
        if (!$episode) {
            return new JsonResponse(['error' => 'Episode not found'], 404);
        }

        $reviews = $episode->getReviews();
        if ($reviews->isEmpty()) {
            $avgSentimentScore = 0.0;
        } else {
            $sentimentScores = $reviews->map(fn($r) => $r->getSentimentScore())->toArray();
            $avgSentimentScore = array_sum($sentimentScores) / count($sentimentScores);
        }

        return new JsonResponse([
            'name' => $episode->getName(),
            'airDate' => $episode->getAirDate(),
            'avgSentimentScore' => $avgSentimentScore,
            'reviews' => $reviews->map(fn($r) => $r->getText())->toArray(),
        ]);
    }
}
