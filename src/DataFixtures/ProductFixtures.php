<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Entity\ProductImage;
use Bezhanov\Faker\Provider\Device;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        $brands = $manager->getRepository(ProductBrand::class)->findAll();

        for ($i = 0; $i < 150; $i++) {
            $product = new Product();
            $model = ucfirst(trim($faker->word . ' ' . $faker->optional(0.8)->numberBetween(1, 35)));
            $brand = $faker->randomElement($brands);
            $product
                ->setName($model)
                ->setBrand($brand)
                ->setEanCode($faker->ean13())
                ->setReference(strtoupper(substr($brand->getName(), 0, 3)) . $faker->bothify('#####'))
            ;

            for ($j = 0; $j < $faker->numberBetween(0, 4); $j++) {
                $image = new ProductImage();
                $image->setImagePath($faker->imageUrl());
                $product->addImage($image);
            }

            $manager->persist($product);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            ProductBrandFixtures::class
        ];
    }


}
