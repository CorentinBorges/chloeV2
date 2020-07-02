<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
/*TODO: not gitignor+change values*/
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'Crimsonpeak20?'))
            ->setRoles(["ROLE_ADMIN"])
            ->setUsername("chloe");
        $manager->persist($user);
        $manager->flush();
    }

    protected function loadData(ObjectManager $objectManager)
    {
        // TODO: Implement loadData() method.
    }
}
