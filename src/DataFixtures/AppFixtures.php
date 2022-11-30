<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\IpStatus;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\IpUtils;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ipStatus1 = New IpStatus();
        $ipStatus1 -> setIp('127.0.0.1');
        // $ipStatus1 -> setStatus(new PingHost());
        $ipStatus1 -> setCreatedAt(new DateTime());

        $manager -> persist($ipStatus1);

        $manager->flush();
    }
}
