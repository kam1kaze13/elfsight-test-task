<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Review;
use App\Service\SentimentAnalysisService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
            throw new NotFoundHttpException('Episode not found');
        }

        $text = $request->getPayload()->get('text');
        if (!$text) {
            throw new BadRequestHttpException('Text cannot be empty');
        }

        $review = new Review();
        $review->setEpisode($episode);
        $review->setText($text);
        $review->setSentimentScore($analysisService->getSentimentPosValue($text));

        $entityManager->persist($review);
        $entityManager->flush();

        return new JsonResponse(
            data: ['message' => 'Review submitted successfully']
        );
    }
}
