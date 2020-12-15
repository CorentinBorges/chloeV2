<?php

namespace App\DataFixtures;

use App\Entity\WebsiteInfos;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WebsiteInfosFixture extends Fixture
{

//    TODO: getignors+infos
    public function load(ObjectManager $manager)
    {
        $infos = new WebsiteInfos();
        $infos->setInstagram('https://www.instagram.com/chloeowyn/')
            ->setMail('chloesimonneaud@gmail.com');
        $manager->persist($infos);
        $manager->flush();
    }
}
