<?php

namespace App\Controller;

use App\Entity\Episode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
            throw new NotFoundHttpException('Episode not found');
        }

        $reviews = $episode->getReviews();
        $sentimentScores = $reviews->isEmpty() ? [] : $reviews->map(fn($r) => $r->getSentimentScore())->toArray();

        return new JsonResponse([
            'name' => $episode->getName(),
            'airDate' => $episode->getAirDate(),
            'avgSentimentScore' => array_sum($sentimentScores) / count($sentimentScores),
            'reviews' => $reviews->map(fn($r) => $r->getText())->toArray(),
        ]);
    }
}
