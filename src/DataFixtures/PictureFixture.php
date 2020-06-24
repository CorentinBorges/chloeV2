<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class PictureFixture extends Fixture
{
    /**
     * @var Generator
     */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    private static $titles=[
        "arthur",
        "bleu",
        "fille",
        "loup",
        "les archers du nord",
        "notre dame",
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $picture = new Picture();
            $picture->setTitle($this->faker->randomElement(self::$titles));
            $picture->setAlt($picture->getTitle());
            $picture->setFileName($picture->getTitle().".png");
            $this->randomPages($picture, $i);
            $manager->persist($picture);
        }
        $manager->flush();
    }

    public function randomPages(Picture $entity,int $j,int $chancesOfTrue=70)
    {
        $var=[];
        for ($i = 0; $i < 3; $i++) {
            $var[]=$this->faker->boolean($chancesOfTrue);
            }
        if($var[0]){
            $entity->setPapier($j);
        }
        if($var[1]){
            $entity->setPortfolio($j);
        }
        if($var[2]){
            $entity->setNumerique($j);
        }
    }
}
