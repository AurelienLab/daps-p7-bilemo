<?php

namespace App\DataFixtures;

use App\Entity\ProductBrand;
use Bezhanov\Faker\Provider\Device;
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
                ->setLogoPath($faker->optional(0.7)->imageUrl(word: $brand))
            ;

            $manager->persist($productBrand);
        }

        $manager->flush();
    }


}
