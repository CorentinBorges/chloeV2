<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    /**
     * @var Generator
     */
    protected $faker;

    /**
     * @var ObjectManager
     */
    protected $manager;

    abstract protected function loadData(ObjectManager $objectManager);


    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadData($manager);
        $manager->flush();
    }

    public function createMany($className, int $count, callable $factory)
    {
        for ($i=0; $i < $count; $i++) {
            $factory();
        }
    }
}
