<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $episode = new Episode();
        $episode->setName('Some name');
        $episode->setAirDate('December 2, 2013');

        $manager->persist($episode);
        $manager->flush();
    }
}
