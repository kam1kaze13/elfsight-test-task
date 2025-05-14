<?php

namespace App\Entity\Traits;

use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Adds createdAt and updatedAt fields to entities.
 * Entities using this trait must have the HasLifecycleCallbacks annotation
 *
 * @ORM\HasLifecycleCallbacks
 */
trait HasTimestamps
{
    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $updatedAt;

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setTimestamps(): void
    {
        $this->createdAt ??= Carbon::now();
        $this->updatedAt = Carbon::now();
    }
}
