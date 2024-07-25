<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {


        $userAdmin = new User();
        $userAdmin->setName('Modérateur');
        $userAdmin->setFirstname('Modérateur');
        $userAdmin->setEmail('moderateur@notaresto.com');
        $userAdmin->setPassword($this->encoder->encodePassword($userAdmin, 'notaresto'));
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($userAdmin);

        $userClient = new User();
        $userClient->setName('Client');
        $userClient->setFirstname('Client');
        $userClient->setEmail('client@notaresto.com');
        $userClient->setPassword($this->encoder->encodePassword($userAdmin, 'notaresto'));
        $userClient->setRoles(['ROLE_CLIENT']);
        $manager->persist($userClient);

        $userRestaurateur = new User();
        $userRestaurateur->setName('Restaurateur');
        $userRestaurateur->setFirstname('Restaurateur');
        $userRestaurateur->setEmail('restaurateur@notaresto.com');
        $userRestaurateur->setPassword($this->encoder->encodePassword($userAdmin, 'notaresto'));
        $userRestaurateur->setRoles(['ROLE_RESTO']);
        $manager->persist($userRestaurateur);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
        );
    }
}
