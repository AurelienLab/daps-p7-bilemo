<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager): void
    {
        $customer = $this->getReference('customer');
        $amount = 34;
        $faker = Factory::create();

        for ($i = 0; $i < $amount; $i++) {
            $user = new User();
            $user
                ->setCustomer($customer)
                ->setEmail($faker->email)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhone($faker->optional(0.7)->phoneNumber)
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            CustomerFixtures::class,
        ];
    }


}
