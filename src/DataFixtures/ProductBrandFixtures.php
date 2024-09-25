<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\ProductBrand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProductBrandFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {

        $brands = [
            "Nokia",
            "Alcatel",
            "Benefon",
            "Samsung",
            "Oppo",
            "Motorola",
            "Apple",
            "Ericsson",
            "Panasonic",
            "Sony",
            "Fairphone",
            "Philips",
            "NEC",
            "Google",
            "OnePlus"
        ];

        $faker = Factory::create();

        foreach ($brands as $brand) {

            $productBrand = new ProductBrand();

            $productBrand
                ->setName($brand)
            ;

            // Randomly create logo
            $withLogo = $faker->boolean(70);
            if ($withLogo) {
                $logo = new Media();
                $logo->setFilePath($faker->imageUrl(word: $brand));

                $productBrand->setLogo($logo);
            }

            $manager->persist($productBrand);
        }

        $manager->flush();
    }


}
