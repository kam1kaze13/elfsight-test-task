<?php

namespace App\Entity;

use App\Entity\Traits\HasTimestamps;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Review
{
    use HasTimestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Episode::class, inversedBy: 'reviews')]
    private Episode $episode;

    #[ORM\Column(type: 'text')]
    private string $text;

    #[ORM\Column(type: 'float', options: ['default' => 0.00])]
    private float $sentimentScore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEpisode(): Episode
    {
        return $this->episode;
    }

    public function setEpisode(?Episode $episode): self
    {
        $this->episode = $episode;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getSentimentScore(): float
    {
        return $this->sentimentScore;
    }

    public function setSentimentScore(float $sentimentScore): self
    {
        $this->sentimentScore = $sentimentScore;
        return $this;
    }
}
