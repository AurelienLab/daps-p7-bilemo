<?php

namespace App\DataFixtures;

use App\Entity\Attribute;
use App\Entity\Product;
use App\Entity\ProductAttribute;
use App\Entity\ProductBrand;
use App\Entity\ProductImage;
use Bezhanov\Faker\Provider\Device;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProductAttributeFixtures extends Fixture implements DependentFixtureInterface
{


    public function __construct(
        private AttributeFixtures $attributeFixtures
    ) {
    }


    public function load(ObjectManager $manager): void
    {

        $products = $manager->getRepository(Product::class)->findAll();
        $attributes = $manager->getRepository(Attribute::class)->findAll();
        $faker = Factory::create();

        foreach ($products as $product) {
            $registeredAttributes = [];
            $attributesToComplete = rand(4, 10);

            while (count($registeredAttributes) < $attributesToComplete) {
                $attribute = $faker->randomElement($attributes);
                if (in_array($attribute->getId(), $registeredAttributes)) {
                    continue;
                }

                $productAttribute = new ProductAttribute();
                $productAttribute
                    ->setProduct($product)
                    ->setAttribute($attribute)
                    ->setValue($this->attributeFixtures->getValueForAttribute($attribute->getName()))
                ;

                $manager->persist($productAttribute);

                $registeredAttributes[] = $attribute->getId();
            }
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            ProductFixtures::class,
            AttributeFixtures::class
        ];
    }


}
