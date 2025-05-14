<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RickAndMortyApiService
{
    private HttpClientInterface $client;
    private string $ramApi = 'https://rickandmortyapi.com/api';

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getListOfEpisodes(int $page = 1): array
    {
        $response = $this->client->request('GET', $this->ramApi.'/episode?page='.$page);

        if ($response->getStatusCode() !== 200) {
            return ['error' => 'Rick and Morty API Error'];
        }

        return [
            'info' => $response->toArray()['info'],
            'episodes' => $response->toArray()['results'],
        ];
    }
}
