<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class CustomerFixtures extends Fixture
{


    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // Admin
        $admin = new Customer();
        $password = $this->passwordHasher->hashPassword($admin, 'BMadmin2k24#');
        $admin
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@bilemo.com')
            ->setPassword($password)
            ->setCompanyName('BileMo')
        ;
        $manager->persist($admin);

        // User
        $user = new Customer();
        $password = $this->passwordHasher->hashPassword($user, 'BMuser2k24#');
        $user
            ->setRoles(['ROLE_USER'])
            ->setEmail('user@bilemo.com')
            ->setPassword($password)
            ->setCompanyName($faker->company)
        ;
        $manager->persist($user);
        $this->addReference('customer', $user);

        $manager->flush();
    }


}
