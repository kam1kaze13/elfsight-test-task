<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Review;
use App\Service\SentimentAnalysisService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ReviewController
{
    #[Route(path: '/api/review/submit/{episodeId}', methods: ['POST'])]
    public function submitReview(
        int $episodeId,
        Request $request,
        EntityManagerInterface $entityManager,
        SentimentAnalysisService $analysisService,
    ): JsonResponse
    {
        $episode = $entityManager->getRepository(Episode::class)->find($episodeId);
        if (!$episode) {
            return new JsonResponse(['error' => 'Episode not found'], 404);
        }

        $text = $request->getPayload()->get('text');
        if (!$text) {
            return new JsonResponse(['error' => 'Text cannot be empty'], 400);
        }

        $review = new Review();
        $review->setEpisode($episode);
        $review->setText($text);
        $review->setSentimentScore($analysisService->getSentimentPosValue($text));

        $entityManager->persist($review);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Review submitted successfully']);
    }
}
